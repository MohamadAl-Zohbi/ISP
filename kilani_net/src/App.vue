<script setup>
import { RouterView } from 'vue-router';
import { ref } from 'vue';
import axios from 'axios';
import { host } from './host';
import Navigation from '@/components/Navigation.vue';
// import 'vuetify/dist/vuetify.min.css';
// 
const login_nav = ref(location.pathname != '/login' && location.pathname != '/print-payment');
const position = ref(location.pathname);
// console.log(host)
if (!localStorage.getItem('token')) {
  if (location.pathname != '/login') {
    location.replace('/login');
  }
} else {
  setInterval(async () => {
    try {
      const response = await axios.get(`http://${host}:8000/api/check`, {
        headers: {
          Authorization: `Bearer ${localStorage.getItem('token')}`,
        },
      });

      if (response.data.status) {
        localStorage.clear()
        location.replace('/')
      }
    } catch (error) {
      localStorage.clear()
      location.replace('/')
      console.error("There was an error during the search:", error);
    }
  }, 10000);
}

components: {
  Navigation
}

</script>

<template>
  <Navigation v-if="login_nav" :position="position" />
  <!-- <div style="position: absolute;float: left;width: 200px;height: 400px; background-color: red;">
    
  </div> -->
  <!-- <SideBar /> -->

  <RouterView />
</template>
<style scoped>
* {
  padding: 10px;
}
</style>
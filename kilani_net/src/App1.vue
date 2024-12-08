<script setup>
// Admin
import { RouterView } from 'vue-router';
import { ref } from 'vue';
import axios from 'axios';
import { host } from './host';
import Navigation from '@/components/Navigation.vue';
// import 'vuetify/dist/vuetify.min.css';
// 

const login_nav = ref(location.pathname != '/login' && location.pathname != '/print-payment');
// const position = ref(location.pathname);
if (location.pathname.includes('super')) {
  location.replace('/404')
}
// console.log(position)
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

      if (response.data.status == false) {
        localStorage.clear()
        location.replace('/')
      }
    } catch (error) {
      localStorage.clear()
      location.replace('/')
      console.error("There was an error during the search:", error);
    }
  }, 5000);
}

components: {
  Navigation
}

</script>

<template>
  <!-- this page for admin
  <br>
  try to make changes for some changes in the router (super) to never create a new components for lite speed good luck
  !!!! -->

  <RouterView />

</template>
<style scoped>
* {
  padding: 10px;
}
</style>
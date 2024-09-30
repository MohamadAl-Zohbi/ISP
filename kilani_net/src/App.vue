<script setup>
import {RouterView} from 'vue-router';
import {ref} from 'vue';
import Navigation from './components/Navigation.vue';
// import 'vuetify/dist/vuetify.min.css';
// 
const login_nav = ref(location.pathname != '/login');
const position = ref(location.pathname);

if (!localStorage.getItem('token')) {
  if (location.pathname != '/login') {
    location.replace('/login')
  }
}

components: {
  Navigation
}

</script>

<template>
  <Navigation v-if="login_nav" :position="position"/>
  <!-- <div style="position: absolute;float: left;width: 200px;height: 400px; background-color: red;">
    
  </div> -->
  <!-- <SideBar /> -->

  <RouterView />
</template>
<style scoped>
*{
  padding: 10px;
}
</style>
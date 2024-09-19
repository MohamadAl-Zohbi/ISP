<script setup>
import { RouterLink, RouterView } from 'vue-router';
// import TheWelcome from './components/TheWelcome.vue';

if (!localStorage.getItem('token')) {
  if (location.pathname != '/login') {
    location.replace('/login')
  }
}

</script>

<template>


  <RouterView />
</template>

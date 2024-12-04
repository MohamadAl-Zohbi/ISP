<script>
import { host } from '@/host';
import axios from 'axios';
import WarningMessage from '@/components/WarningMessage.vue';
import Loading from '@/components/LoadingBox.vue';
export default {
  data() {
    return {
      username: '',
      password: '',
      is_loading: false,
      is_closed_warning: false,
      details: '',
    };
  },
  components: {
    WarningMessage,
    Loading
  },
  methods: {
    async login() {
      this.is_loading = true;
      try {
        const response = await axios.post(`http://${host}:8000/api/login`, {
          username: this.username,
          password: this.password,
        });
        this.is_loading = false

        console.log('Post created:', response.data);
        if (response.data.status == true) {
          localStorage.setItem('token', response.data.token);
          localStorage.setItem('name', response.data.details.name);
          location.replace('/super');
        } else {
          this.is_closed_warning = true
          this.details = response.data.details
        }

      } catch (error) {
        this.is_loading = false
        this.is_closed_warning = true
          this.details = response.data.details

        console.error("There was an error creating the post:", error);
      }
    },
    closeWarning() {
      this.is_closed_warning = false
    }

  }
};
</script>

<template>
  <Loading v-if="is_loading"/>

  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
      <h2 class="text-2xl font-bold text-center mb-6">Login</h2>

      <form @submit.prevent="login">
        <div class="mb-4">
          <label for="username" class="block text-sm font-medium text-gray-700">User Name</label>
          <input v-model="username" type="text" id="username"
            class="mt-1 p-2 w-full border rounded-md focus:ring focus:ring-indigo-200"
            placeholder="Enter your username" />
        </div>

        <div class="mb-6">
          <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
          <input v-model="password" type="password" id="password"
            class="mt-1 p-2 w-full border rounded-md focus:ring focus:ring-indigo-200"
            placeholder="Enter your password" />
        </div>

        <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-indigo-500">
          Login
        </button>
  
      </form>
      <transition
      enter-active-class="transition-opacity ease-out duration-500"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition-opacity ease-in duration-500"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
  <WarningMessage v-if="is_closed_warning" :msg="closeWarning" :details="details" />
</transition>
    </div>
    
  </div>
</template>

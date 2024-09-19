<script>
import axios from 'axios';
// import vue from 'vue'
// import TheWelcome from '../components/TheWelcome.vue';
import WarningMessage from './WarningMessage.vue';
export default {
  data() {
    return {
      username: '',
      password: '',
      waiting: false
    };
  },
  components: {
WarningMessage
  }, 
  methods: {
    async login() {
      this.waiting = true;
      try {
        const response = await axios.post('http://127.0.0.1:8000/api/login', {
          username: this.username,
          password: this.password,
        });
        this.waiting = false

        console.log('Post created:', response.data);
        if (response.data.status == true) {
          localStorage.setItem('token', response.data.token);
          location.replace('/');
        }

      } catch (error) {
        this.waiting = false

        console.error("There was an error creating the post:", error);
      }
    }
  }
};
</script>

<!-- ./src/components/Login.vue -->
<template>


  <!-- <TheWelcome/> -->

  <WarningMessage/>
  <div v-if="waiting" style="background-color: red;">waiting...</div>


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
    </div>
  </div>
</template>

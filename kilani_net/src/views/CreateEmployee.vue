<template>
    <LoadingBox v-if="is_loading" />

    <div class="max-w-md mx-auto p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Employee Form</h2>


        <form @submit.prevent="submitForm" class="space-y-4">

            <div>
                <label for="employee" class="block text-sm font-medium text-gray-700">Employee Name:</label>
                <input type="text" v-model="name" required placeholder="Name..."
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">UserName:</label>
                <input type="text" v-model="username" placeholder="userName ..."
                  required  class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password:</label>
                <input type="password" v-model="password" placeholder="password ..." required
                    class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
            </div>

            <div>
                <label for="rank" class="block text-sm font-medium text-gray-700">Rank:</label>
                <select v-model="rank" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option disabled value="">Select an option</option>
                    <option value="super">super</option>
                    <option value="admin">admin</option>
                    <option value="user">user</option>
                </select>
            </div>


        


            <button type="submit" @click="submit()"
                class="w-full py-2 px-4 bg-gray-600 text-white font-semibold rounded-md shadow hover:bg-gray-700 transition duration-200">
                Submit
            </button>
        </form>
    </div>
</template>

<script>
import axios from 'axios';
import LoadingBox from '@/components/LoadingBox.vue';
export default {
    data() {
        return {
            name: '',
            expiry: '',
            username: '',
            nationality: '',
            description: ' ',
            password: '',
            number: '',
            location: '',
            rank:'',
            is_loading: false,
        };
    },
    methods: {
        async submit() {
            if (!this.name || !this.username || !this.password || !this.rank) {
                return false;
            }
            let token = localStorage.getItem('token');
            try {
                this.is_loading = true;

                const response = await axios.post('http://localhost:8000/api/create_employee', {
                    name: this.name,
                    username: this.username,
                    password: this.password,
                    rank: this.rank,
                    is_frozen: '0',
                }, {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                });
                this.is_loading = false
                console.log('Post created:', response.data);
            } catch (error) {
                this.is_loading = false
                this.is_closed_warning = true
                this.details = response.data.details

                console.error("There was an error creating the post:", error);
            }

            location.replace('manage-customers?search=')
        },


    },

    components: {
        LoadingBox
    }
};
</script>

<style scoped>
/* Additional styles can go here if needed */
</style>
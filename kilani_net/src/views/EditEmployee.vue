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
                <label for="rank" class="block text-sm font-medium text-gray-700">Rank:</label>
                <select v-model="rank" required value=""
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option disabled value="">Select an option</option>
                    <option value="super">Super</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>

            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">UserName:</label>
                <input type="text" v-model="username" placeholder="userName ..." required
                    class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
            </div>

            <!-- <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password:</label>
                <input type="password" v-model="password" placeholder="password ..." required
                    class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
            </div> -->
            <div class="relative">
                <label for="password" class="block text-sm font-medium text-gray-700">Password:</label>
                <div class="relative">
                    <input :type="isPasswordVisible ? 'text' : 'password'" v-model="password"
                        class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="password ..." />
                    <button type="button" @click="togglePasswordVisibility"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700 focus:outline-none">
                        <svg v-if="isPasswordVisible" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm1.618-7.832a9 9 0 00-9.236 0M4.5 8.132a8.976 8.976 0 00-2.488 3.868 9 9 0 0016.976 0 8.978 8.978 0 00-2.488-3.868m-2.62 4.754a9.008 9.008 0 011.236 1.88" />
                        </svg>
                        <svg v-else xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.875 18.825A10.05 10.05 0 019 19a10 10 0 010-20 10.05 10.05 0 014.875 1.175M9.5 7.5a3 3 0 013 3 3 3 0 01-3 3m0-12a8.933 8.933 0 016.75 3.675m.208 1.36a8.933 8.933 0 01.042 8.248" />
                        </svg>
                    </button>
                </div>
            </div>
            <div>
                <label for="freez" class="block text-sm font-medium text-gray-700">Freez:</label>
                <select v-model="is_frozen" required value=""
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option disabled value="">Select an option</option>
                    <option value="0">Active</option>
                    <option value="1">UnActive</option>
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
import { host } from '@/host';
import axios from 'axios';
import LoadingBox from '@/components/LoadingBox.vue';
export default {
    data() {
        return {
            name: '',
            username: '',
            rank: '',
            password: '',
            employee: [],
            is_frozen: false,
            is_loading: false,
            isPasswordVisible: false,
        };
    },
    methods: {
        async submit() {
            if (!this.name || !this.rank || !this.password || !this.username) {
                return false;
            }
            let token = localStorage.getItem('token');
            try {
                this.is_loading = true;

                const response = await axios.put(`http://${host}:8000/api/update_employee/`+this.getParam(), {
                    name: this.name,
                    username: this.username,
                    password: this.password,
                    rank: this.rank,
                    is_frozen: this.is_frozen,
                }, {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                });
                this.is_loading = false
                console.log('Post created:', response.data);
            } catch (error) {
                this.is_loading = false
                console.error("There was an error creating the post:", error);
            }

            location.replace('manage-employees')
        },

        getParam() {
            let queryString = window.location.search;
            let urlParams = new URLSearchParams(queryString);
            let value = urlParams.get('id');
            return value;
        },
        togglePasswordVisibility() {
            this.isPasswordVisible = !this.isPasswordVisible;
        }

    },
    async mounted() {
        this.is_loading = true
        let token = localStorage.getItem('token');
        try {
            const response = await axios.get(`http://${host}:8000/api/show/${this.getParam()}`, {
                headers: {
                    Authorization: `Bearer ${token}`,
                }
            });
            this.is_loading = false


            console.log(response.data);
            this.employee = response.data.details;
            this.name = this.employee.name;
            this.rank = this.employee.rank;
            this.username = this.employee.username;
            this.is_frozen = this.employee.is_frozen;
            this.password = this.employee.password;
        } catch (error) {
            this.is_loading = false

            console.error("There was an error during the search:", error);
        };
    },
    components: {
        LoadingBox
    }
};
</script>

<style scoped>
/* Additional styles can go here if needed */
</style>
<template>
    <LoadingBox v-if="is_loading" />

    <div class="max-w-md mx-auto p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Customer Form</h2>


        <form @submit.prevent="submitForm" class="space-y-4">

            <div>
                <label for="customer" class="block text-sm font-medium text-gray-700">Customer Name:</label>
                <input type="text" v-model="name" required placeholder="Name..."
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label for="expiry" class="block text-sm font-medium text-gray-700">Expiry: mm/dd/yyyy</label>
                <input type="date" v-model="expiry" disabled
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
            </div>
            <div>
                <label for="nationality" class="block text-sm font-medium text-gray-700">Nationality:</label>
                <select v-model="nationality" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option disabled value="">Select an option</option>
                    <option value="lebanon">Lebanees</option>
                    <option value="syria">Syrian</option>
                    <option value="pelastine">Paelastine</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <div>
                <label for="number" class="block text-sm font-medium text-gray-700">Phone Number:</label>
                <input type="text" v-model="number" required placeholder="number ..."
                    class="mt-1 block w-full border-gray-700 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
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
                <label for="description" class="block text-sm font-medium text-gray-700">Description:</label>
                <input type="text" v-model="description" placeholder="description ..."
                    class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
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
            <div>
                <label for="location" class="block text-sm font-medium text-gray-700">Location:</label>
                <textarea required type="text" v-model="location" style="border: none; background-color: #f7f7f7"
                    class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
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
            customer: [],
            number: '',
            location: '',
            is_loading: false,
            isPasswordVisible:false,
            is_frozen:''
        };
    },
    methods: {
        // expiryDate() {
        //     const today = new Date();
        //     // Add one month
        //     // Format date as YYYY-MM-DD
        //     return today.toISOString().split('T')[0];
        // },
        // test() {
        //     this.submit();
        // },
        async submit() {
            if (!this.name || !this.number || !this.location || !this.nationality || !this.username || !this.password) {
                return false;
            }
            let token = localStorage.getItem('token');
            try {
                this.is_loading = true;

                const response = await axios.put('http://localhost:8000/api/update_customer/'+this.getParam(), {
                    name: this.name,
                    number: this.number,
                    location: this.location,
                    expiry: this.expiry,
                    nationality: this.nationality,
                    user: this.username,
                    pass: this.password,
                    description: this.description,
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
                this.is_closed_warning = true
                console.error("There was an error creating the post:", error);
            }

            location.replace('manage-customers?search=')
        },
        getParam() {
            let queryString = window.location.search;
            let urlParams = new URLSearchParams(queryString);
            let value = urlParams.get('id');

            return value;
        },
        togglePasswordVisibility(){
            this.isPasswordVisible = !this.isPasswordVisible;
        }

    },
    async mounted() {
        this.is_loading = true
        let token = localStorage.getItem('token');
        try {
            const response = await axios.get(`http://localhost:8000/api/get_customer/${this.getParam()}`, {
                headers: {
                    Authorization: `Bearer ${token}`,
                }
            });
            this.is_loading = false


            console.log(response.data);
            this.customer = response.data.details;
            this.name = this.customer.name;
            this.expiry = this.customer.expiry;
            this.nationality = this.customer.nationality;
            this.number = this.customer.number;
            this.username = this.customer.user;
            this.password = this.customer.pass;
            this.description = this.customer.description;
            this.location = this.customer.location;
            this.is_frozen = this.customer.is_frozen;
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
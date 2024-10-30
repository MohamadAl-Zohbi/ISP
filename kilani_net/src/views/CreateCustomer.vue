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

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password:</label>
                <input type="password" v-model="password" placeholder="password ..." required
                    class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description:</label>
                <input type="text" v-model="description" placeholder="description ..."
                    class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
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
            number: '',
            location: '',
            is_loading: false,
        };
    },
    methods: {
        expiryDate() {
            const today = new Date();
            // Add one month
            // Format date as YYYY-MM-DD
            return today.toISOString().split('T')[0];
        },

        async submit() {
            if (!this.name || !this.number || !this.location || !this.nationality || !this.username || !this.password) {
                return false;
            }
            let token = localStorage.getItem('token');
            try {
                this.is_loading = true;

                const response = await axios.post('http://localhost:8000/api/create_customer', {
                    name: this.name,
                    number: this.number,
                    location: this.location,
                    expiry: this.expiryDate(),
                    nationality: this.nationality,
                    user: this.username,
                    pass: this.password,
                    description: this.description,
                    is_frozen: '0',
                }, {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                });
                this.is_loading = false
                console.log('Post created:', response.data);
                if (response.data.details == 'no permission') {
                    location.replace('no-permission')

                }
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
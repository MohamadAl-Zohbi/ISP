<template>
    <LoadingBox v-if="is_loading" />

    <div class="max-w-md mx-auto p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Service Form</h2>


        <form @submit.prevent="submitForm" class="space-y-4">

            <div>
                <label for="service" class="block text-sm font-medium text-gray-700">Service Name:</label>
                <input type="text" v-model="service_name" required placeholder="Service Name..."
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">Price:</label>
                <input type="text" v-model="price" placeholder="price ..." required
                @keypress="(event) => {
                    const char = String.fromCharCode(event.keyCode); // Get the pressed key
                    if (!/^\d$/.test(char) && char != '.') {  // Check if the character is not a digit
                        event.preventDefault();  // Prevent non-digit input
                    }
                }"
                    class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
            </div>


            <div>
                <label for="package" class="block text-sm font-medium text-gray-700">Package:</label>
                <input type="text" v-model="package" placeholder="package ..." required
                    class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description:</label>
                <input type="text" v-model="description" placeholder="description ..."
                    class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
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
            service_name: '',
            price: '',
            package: '',
            description: '',
            service: [],
            is_loading: false,
        };
    },
    methods: {
        async submit() {
            if (!this.service_name || this.price == '' || !this.package) {
                return false;
            }
            let token = localStorage.getItem('token');
            try {
                this.is_loading = true;

                const response = await axios.put(`http://${host}:8000/api/update_service/`+this.getParam(), {
                    service: this.service_name,
                    price: this.price,
                    package: this.package,
                    description: this.description,
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

            location.replace('manage-services')
        },

        getParam() {
            let queryString = window.location.search;
            let urlParams = new URLSearchParams(queryString);
            let value = urlParams.get('id');
            return value;
        },

    },
    async mounted() {
        this.is_loading = true
        let token = localStorage.getItem('token');
        try {
            const response = await axios.get(`http://${host}:8000/api/get_service/${this.getParam()}`, {
                headers: {
                    Authorization: `Bearer ${token}`,
                }
            });
            this.is_loading = false


            console.log(response.data);
            this.service = response.data.details;
            this.service_name = this.service.service;

            this.price = this.service.price;
            this.package = this.service.package;
            this.description = this.service.description;
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
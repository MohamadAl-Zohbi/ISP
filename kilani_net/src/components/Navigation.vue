<template>
    <nav class="bg-gray-800 p-4 shadow-md">
        <div class="container mx-auto flex items-center justify-between">
            <div>
                <button @click="toggleMenu" class="text-white focus:outline-none mr-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
            </div>
            <!-- Logo -->
            <div class="text-white text-2xl font-bold">
                <a href="#" class="hover:text-gray-400 location">{{ location }}</a>
            </div>

            <!-- Search Field -->
            <div class="relative flex-1 mx-4">
                <input type="text" v-model="searchQuery" placeholder="Search..." @keydown.enter="search"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                <!-- Search Icon -->
                <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-500"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 4a7 7 0 014 13.856A7 7 0 1111 4z" />
                </svg>
            </div>
            <div class="text-white text-2xl font-bold">
                <a href="/" class="hover:text-gray-400 location">{{ name.substring(0, 5) }}...</a>
            </div>
            <button @click="handleLogout" class="flex items-center p-2 text-gray-600 hover:text-red-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2h5a2 2 0 012 2v1" />
                </svg>
                <span class="ml-2">Logout</span>
            </button>
        </div>


    </nav>

    <transition enter-active-class="transition ease-out duration-500" enter-from-class="opacity-0 transform scale-95"
        enter-to-class="opacity-100 transform scale-100" leave-active-class="transition ease-in duration-500"
        leave-from-class="opacity-100 transform scale-100" leave-to-class="opacity-0 transform scale-95">

        <aside v-if="isOpen" :class="[
            'bg-gray-800 text-white w-64 space-y-6 py-7 px-2 inset-y-0 left-0 transform',
            isOpen ? 'translate-x-0' : '-translate-x-full',
            'transition-transform duration-300 ease-in-out shadow-2xl w-64 p-4 overflow-y-auto'
        ]" style="position: absolute; margin-top: 73.6px; ">
            <!-- Logo -->

            <div class="text-white text-2xl font-bold text-center block">
                ISP
                <svg @click="toggleMenu" style="float: right; cursor: pointer;" width="30px" height="30px"
                    viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="#000000">
                    <line x1="16" y1="16" x2="48" y2="48" />
                    <line x1="48" y1="16" x2="16" y2="48" />
                </svg>
            </div>

            <!-- Navigation Links -->
            <nav style="">
                <details style="margin-bottom: 10px;">
                    <summary style="cursor: pointer;">
                        &nbsp;&nbsp;
                        Customer
                    </summary>
                    <a href="create-customer" style="padding-left:50px ;"
                        class=" block py-1 px-4 rounded transition duration-200 hover:bg-gray-700">
                        Add Customer
                    </a><a href="manage-customers?search=" style="padding-left:50px ;"
                        class=" block py-1 px-4 rounded transition duration-200 hover:bg-gray-700">
                        Manage Customers
                    </a>
                </details>

                <details style="margin-bottom: 10px;">
                    <summary style="cursor: pointer;">
                        &nbsp;&nbsp;
                        Employees
                    </summary>
                    <a href="create-employee" style="padding-left:50px ;"
                        class=" block py-1 px-4 rounded transition duration-200 hover:bg-gray-700">
                        Add Employee
                    </a><a href="manage-employees" style="padding-left:50px ;"
                        class=" block py-1 px-4 rounded transition duration-200 hover:bg-gray-700">
                        Manage Employees
                    </a>
                    <a href="#" style="padding-left:50px ;"
                        class=" block py-1 px-4 rounded transition duration-200 hover:bg-gray-700">
                        Daily Logs
                    </a>
                </details>

                <details style="margin-bottom: 10px;">
                    <summary style="cursor: pointer;">
                        &nbsp;&nbsp;
                        Services
                    </summary>
                    <a href="#" style="padding-left:50px ;"
                        class=" block py-1 px-4 rounded transition duration-200 hover:bg-gray-700">
                        Add Service
                    </a><a href="#" style="padding-left:50px ;"
                        class=" block py-1 px-4 rounded transition duration-200 hover:bg-gray-700">
                        Manage Services
                    </a>
                    <a href="#" style="padding-left:50px ;"
                        class=" block py-1 px-4 rounded transition duration-200 hover:bg-gray-700">
                        Daily Services
                    </a>
                    <a href="#" style="padding-left:50px ;"
                        class=" block py-1 px-4 rounded transition duration-200 hover:bg-gray-700">
                        Monthly Services
                    </a>
                </details>

                <details style="margin-bottom: 10px;">
                    <summary style="cursor: pointer;">
                        &nbsp;&nbsp;
                        Renews
                    </summary>
                    <a href="#" style="padding-left:50px ;"
                        class=" block py-1 px-4 rounded transition duration-200 hover:bg-gray-700">
                        Create Renew
                    </a><a href="#" style="padding-left:50px ;"
                        class=" block py-1 px-4 rounded transition duration-200 hover:bg-gray-700">
                        Monthly Report
                    </a><a href="#" style="padding-left:50px ;"
                        class=" block py-1 px-4 rounded transition duration-200 hover:bg-gray-700">
                        Daily Managment
                    </a>
                    <a href="#" style="padding-left:50px ;"
                        class=" block py-1 px-4 rounded transition duration-200 hover:bg-gray-700">
                        Daily Renews
                    </a>
                    <a href="#" style="padding-left:50px ;"
                        class=" block py-1 px-4 rounded transition duration-200 hover:bg-gray-700">
                        History
                    </a>
                </details>

                <details style="margin-bottom: 10px;">
                    <summary style="cursor: pointer;">
                        &nbsp;&nbsp;
                        Payments
                    </summary>
                    <a href="#" style="padding-left:50px ;"
                        class=" block py-1 px-4 rounded transition duration-200 hover:bg-gray-700">
                        Add Payment
                    </a>
                    <a href="#" style="padding-left:50px ;"
                        class=" block py-1 px-4 rounded transition duration-200 hover:bg-gray-700">
                        Daily Payments
                    </a>
                    <a href="#" style="padding-left:50px ;"
                        class=" block py-1 px-4 rounded transition duration-200 hover:bg-gray-700">
                        Administration
                    </a><a href="#" style="padding-left:50px;"
                        class=" block py-1 px-4 rounded transition duration-200 hover:bg-gray-700">
                        Yearly Report
                    </a>
                </details>


                <div style="height: 0.5px;background-color: white;">

                </div>
                <a href="#" class="block py-1 px-4 rounded transition duration-200 hover:bg-gray-700">
                    Contact
                </a>
            </nav>
        </aside>
    </transition>
    <!-- </transition> -->
    <LoadingBox v-if="is_loading" />

</template>

<script>
// import { onMounted } from 'vue';
import LoadingBox from './LoadingBox.vue';
import { search } from '@/utils';
// import axios from 'axios';
export default {

    data() {
        return {
            isOpen: false, // For controlling the mobile menu
            searchQuery: '', // Bound to the search input field
            items: ['Vue.js', 'React', 'Angular', 'Svelte', 'Tailwind CSS', 'Bootstrap', 'JavaScript'], // Example items
            location: '',
            is_loading: false,
            name: localStorage.getItem('name')
        };
    },
    props: {
        position: {
            type: String,
            required: true
        }
    },
    methods: {
        toggleMenu() {
            this.isOpen = !this.isOpen;
        },
        setPosition() {
            if (this.position == '/') {
                this.location = "DashBoard";
            } else if (this.position == '/manage-customers') {
                this.location = "Customers";
            } else if (this.position == '/customer-details') {
                this.location = "Customer Renews";
            } else if (this.position == '/create-customer') {
                this.location = "Create Customer";
            } else if (this.position == '/create-employee') {
                this.location = "Create Employee";
            }
        },
        async search() {
            // if(!(location.pathname == '/search')){
            location.replace('/manage-customers?search=' + this.searchQuery.toLowerCase().trim());
            // }else{
            //     this.is_loading = true;
            //     await search(this.searchQuery.toLowerCase().trim());
            //     this.is_loading = false;
            // }
            // // this.is_loading = true;
            // let token = localStorage.getItem('token');
            // try {
            //     const response = await axios.get(`http://localhost:8000/api/search`, {
            //         headers: {
            //             Authorization: `Bearer ${token}`,
            //             // Accept:'application/json' // Include the token in the Authorization header
            //         },
            //         search: this.getParam()

            //     });

            //     this.is_loading = false
            //     console.log(response.data);
            //     this.$router.push({
            //         name: 'search',
            //         query: { search: this.searchQuery.toLowerCase().trim() },
            //         params: {
            //             result: response.data,
            //         }
            //     });
            // } catch (error) {
            //     this.is_loading = false
            //     // this.is_closed_warning = true
            //     // this.details = response.data.details

            //     console.error("There was an error creating the post:", error);
            // }

        },
        getParam() {
            let queryString = window.location.search;
            let urlParams = new URLSearchParams(queryString);
            let value = urlParams.get('search');

            return value;
        },
        handleLogout() {
            localStorage.clear();
            location.replace('login')
        }
    },
    mounted() {
        this.setPosition();
    },
    components: {
        LoadingBox
    }

};
</script>
<style scoped>
@media screen And (max-width:500px) {
    .location {
        font-size: 15px;
    }
}
</style>
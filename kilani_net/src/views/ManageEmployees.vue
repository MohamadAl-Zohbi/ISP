<template>
    <!-- ############## -->
    <LoadingBox v-if="is_loading" />
    <!-- <CustomerDetailsBox v-if="true" :name="name" :created_at="created_at" :expiry="expiry"
        :description="description" :location="location" :nationality="nationality" :number="number" :user="user" :password="password"/> -->

    <div class="mx-auto mt-4" style="padding: 10px;">
        <!-- Search Input -->
        <input v-model="searchQuery" type="text" placeholder="Search..." class="border p-2 mb-4 w-full" autofocus />

        <!-- Data Table -->
        <table class="table-auto w-full bg-white shadow-md rounded">
            <thead>
                <tr style="border-bottom: 1px solid black;">
                    <th @click="sortBy('created_at')" class="cursor-pointer p-4">Created At</th>
                    <th @click="sortBy('updated_at')" class="cursor-pointer p-4">Updated At</th>
                    <th @click="sortBy('name')" class="cursor-pointer p-4">Name</th>
                    <th @click="sortBy('username')" class="cursor-pointer p-4">userName</th>
                    <th @click="sortBy('password')" class="cursor-pointer p-4">Password</th>
                    <th @click="sortBy('rank')" class="cursor-pointer p-4">Rank</th>

                    <th class="cursor-pointer p-4">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(customer, index) in filteredSortedData" :key="index"
                    :class="['border-b', !customer.is_frozen ? '' : 'bg-red-200', 'hover:bg-gray-700', 'hover:!text-white']">

                    <td class="p-1">dd-mm-yyyy<br />{{ new Date(customer.created_at).getDate() }}-{{ new
                        Date(customer.created_at).getMonth() + 1 }}-{{ new Date(customer.created_at).getFullYear()
                        }}</td>
                    <td class="p-1">dd-mm-yyyy<br />{{ new Date(customer.updated_at).getDate() }}-{{ new
                        Date(customer.updated_at).getMonth() + 1 }}-{{ new Date(customer.updated_at).getFullYear()
                        }}</td>

                    <td class="p-1">{{ customer.name }}</td>
                    <td class="p-1">{{ customer.expiry }}</td>
                    <td class="p-1">{{ descriptionFilter(customer.description) }}</td>
                    <td class="p-1">{{ customer.location }}</td>
                    <td class="p-1">{{ customer.nationality }}</td>
                    <td class="p-1">{{ customer.number }}</td>
                    <td class="p-1">{{ customer.user }}...</td>
                    <td class="p-1">{{ customer.pass }}</td>
                    <td class="p-1">
                        <button
                            @click="showCustomerDetails(customer.created_at, customer.name, customer.expiry, customer.description, customer.location, customer.nationality, customer.number, customer.user, customer.pass)"
                            class="px-4 py-2 rounded-lg transition-transform duration-200 transform hover:scale-105 active:scale-95 focus:outline-none"
                            style="margin-right: 1px;">
                            Show
                        </button>
                        <button @click="customerRenew(customer.id)"
                            class="text-blue-600 px-4 py-2 rounded-lg transition-transform duration-200 transform hover:scale-105 active:scale-95 focus:outline-none"
                            style="margin-right: 1px;">
                            Renew
                        </button>
                        <button @click="editCustomer(customer.id)"
                            class="px-4 py-2 rounded-lg transition-transform duration-200 transform hover:scale-105 active:scale-95 focus:outline-none"
                            style="color: red;margin-right: 1px;">
                            Edit
                        </button>
                        <button @click="customerDetails(customer.id)"
                            class="px-4 py-2 rounded-lg transition-transform duration-200 transform hover:scale-105 active:scale-95 focus:outline-none"
                            style="color: green;">
                            Details
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- No Results Found -->
        <p v-if="filteredSortedData.length === 0" class="mt-4 text-gray-500">No results found.</p>
    </div>
</template>

<script>
import LoadingBox from '@/components/LoadingBox.vue';
// import Vuetify from 'vuetify';
import axios from 'axios';

export default {
    data() {
        return {
            searchQuery: '', // Search query for filtering
            sortKey: '', // Key by which to sort
            sortDirection: 1, // 1 for ascending, -1 for descending
            is_loading: false,
            test: '',
            customers: [

            ],
            created_at: '',
            name: '',
            expiry: '',
            description: '',
            location: '',
            nationality: '',
            number: '',
            user: '',
            password: '',
            isOpenDetailsCustomer: false
        };
    },
    computed: {
        filteredSortedData() {
            // Filter based on the search query
            let filteredData = this.customers.filter((customer) => {
                return (
                    customer.created_at.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                    customer.updated_at.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                    customer.name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                    customer.username.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                    customer.password.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                    customer.rank.toLowerCase().includes(this.searchQuery.toLowerCase())
                );
            });

            // Sort the filtered data
            if (this.sortKey) {
                filteredData.sort((a, b) => {
                    let result = 0;
                    if (a[this.sortKey] > b[this.sortKey]) result = 1;
                    if (a[this.sortKey] < b[this.sortKey]) result = -1;
                    return result * this.sortDirection;
                });
            }

            return filteredData;
        },
    },
    methods: {

        // Method to set the sort key and toggle the sort direction
        sortBy(key) {
            if (this.sortKey === key) {
                // Toggle sort direction
                this.sortDirection *= -1;
            } else {
                // Set new sort key
                this.sortKey = key;
                this.sortDirection = 1;
            }
        },

        async getEmployees() {
            this.is_loading = true;
            let token = localStorage.getItem('token');
            try {
                const response = await axios.get(`http://localhost:8000/api/show_all`, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },

                });

                console.log(response.data);
            this.customers = response.data.details;

            } catch (error) {
                console.error("There was an error during the search:", error);
            }

            this.is_loading = false;
        },
        showCustomerDetails(created_at, name, expiry, description, location, nationality, number, user, password) {
            this.created_at = created_at;
            this.name = name;
            this.expiry = expiry;
            this.description = description;
            this.location = location;
            this.nationality = nationality;
            this.number = number;
            this.user = user;
            this.password = password;
            this.isOpenDetailsCustomer = !this.isOpenDetailsCustomer;
        },
        closeCustomerDetailsBox() {
            this.isOpenDetailsCustomer = false
        },
        descriptionFilter(description) {
            if (description != null) {
                return description.substring(0, 10) + '...';
            }
        },
        customerDetails(id) {
            window.open('customer-details?id=' + id);
        },
        customerRenew(id) {
            window.open('create-renew?id=' + id);
        },
        editCustomer(id) {
            window.location.assign('edit-customer?id=' + id);
        }

    },
    mounted() {
        // this.searchQuery = this.getParam();
        this.getEmployees();
    },
    components: {
        LoadingBox,
        // CustomerDetailsBox
    }
};

</script>

<style scoped>
.container {
    max-width: 800px;
}

.table-auto {
    width: 100%;
    text-align: center;
}

.cursor-pointer {
    cursor: pointer;
}
</style>
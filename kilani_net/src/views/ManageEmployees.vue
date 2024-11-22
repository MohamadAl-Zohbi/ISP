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
                <tr v-for="(employee, index) in filteredSortedData" :key="index"
                    :class="['border-b', !employee.is_frozen ? '' : 'bg-red-200', 'hover:bg-gray-700', 'hover:!text-white']">

                    <td class="p-1">dd-mm-yyyy<br />{{ new Date(employee.created_at).getDate() }}-{{ new
                        Date(employee.created_at).getMonth() + 1 }}-{{ new Date(employee.created_at).getFullYear()
                        }}</td>
                    <td class="p-1">dd-mm-yyyy<br />{{ new Date(employee.updated_at).getDate() }}-{{ new
                        Date(employee.updated_at).getMonth() + 1 }}-{{ new Date(employee.updated_at).getFullYear()
                        }}</td>

                    <td class="p-1">{{ employee.name }}</td>
                    <td class="p-1">{{ employee.username }}</td>
                    <td class="p-1">{{ employee.password }}</td>
                    <td class="p-1">{{ employee.rank }}</td>

                    <td class="p-1">


                        <button @click="editEmployee(employee.id)"
                            class="px-4 py-2 rounded-lg transition-transform duration-200 transform hover:scale-105 active:scale-95 focus:outline-none"
                            style="color: red;margin-right: 1px;">
                            Edit
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
import { host } from '@/host';
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
            employees: [

            ],

            isOpenDetailsCustomer: false
        };
    },
    computed: {
        filteredSortedData() {
            // Filter based on the search query
            let filteredData = this.employees.filter((customer) => {
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
                const response = await axios.get(`http://${host}:8000/api/show_all`, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },

                });

                console.log(response.data);
                this.employees = response.data.details;

            } catch (error) {
                console.error("There was an error during the search:", error);
            }

            this.is_loading = false;
        },
        editEmployee(id) {
            window.location.assign('edit-employee?id='+id);
        }

    },
    mounted() {
        this.getEmployees();
    },
    components: {
        LoadingBox,
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
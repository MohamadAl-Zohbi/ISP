<template>
    <LoadingBox v-if="is_loading" />
    <AlertBox v-if="isAlertBox" :isOpen="true" :title="title" :message="message" :closeFunction="closeAlertBox"
        :check="check" :delete="delete" :action="action" />
    <div class="containar">
        <input v-model="searchQuery" type="text" placeholder="Search..." class="border p-2 mb-4 w-full" autofocus />
        <h1 style="text-align: center">
            <ExportExcel
                :headers="['created_at', 'from', 'to', 'employee_name', 'customer_name', 'service', 'status', 'total', 'paid','note']"
                :contents="filteredSortedData" />
        </h1>
        <table class="table-auto w-full bg-white shadow-md rounded" style="text-align: center;">

            <thead>
                <tr style="border-bottom: 1px solid black;">
                    <th class="cursor-pointer p-4" @click="sortBy('created_at')">Created<br>yyyy-mm-dd</th>
                    <th class="cursor-pointer p-4" @click="sortBy('from')">From</th>
                    <th class="cursor-pointer p-4" @click="sortBy('to')">To</th>
                    <th class="cursor-pointer p-4" @click="sortBy('employee_name')">Created By</th>
                    <th class="cursor-pointer p-4" @click="sortBy('customer_name')">Customer Name</th>
                    <th class="cursor-pointer p-4" @click="sortBy('service')">Service</th>
                    <th class="cursor-pointer p-4" @click="sortBy('status')">Status</th>
                    <th class="cursor-pointer p-4" @click="sortBy('total')">Total</th>
                    <th class="cursor-pointer p-4" @click="sortBy('paid')">Paid</th>
                    <th class="cursor-pointer p-4" @click="sortBy('note')">Note</th>
                    <th class="cursor-pointer p-4">Action
                        <!-- <ExportExcel :headers="['name','created_at','expiry','description','location','nationality','number','user','pass']" :contents="filteredSortedData"/> -->
                        <button
                            style="float: right; margin-right: 2%; color:blue;font-size: 15px;text-decoration: underline;"
                            @click="openAlertBox('check')">check</button>

                        <button
                            style="float: right; margin-right: 2%; color:blue;font-size: 15px;text-decoration: underline;"
                            @click="openAlertBox('delete')">delete</button>
                    </th>

                </tr>
            </thead>
            <tbody>
                <tr v-for="(renew, index) in filteredSortedData" :key="index"
                    :class="['border-b', renew.status == 'checked' ? '' : 'bg-red-200', parseInt(renew.total) > parseInt(renew.paid) ? 'text-red-500' : '', 'hover:bg-gray-700', 'hover:!text-white']">

                    <td class="p-1">{{ getDateTime(renew.created_at)[0]
                        }} <br> {{ getDateTime(renew.created_at)[1] }}</td>

                    <td class="p-1 center">{{ renew.from }}</td>

                    <td class="p-1">{{ renew.to }}</td>

                    <td class="p-1">{{ renew.employee_name }}</td>
                    <td class="p-1">{{ renew.customer_name }}</td>
                    <td class="p-1">{{ renew.service }}</td>
                    <td class="p-1">{{ renew.status }}</td>
                    <td class="p-1">{{ renew.total }}</td>
                    <td class="p-1">{{ renew.paid }}</td>
                    <td class="p-1">{{ renew.note }}</td>
                    <td class="p-1">
                        <a :href="'/super/create-payment?id=' + renew.id"
                            class="px-4 py-2 rounded-lg transition-transform duration-200 transform hover:scale-105 active:scale-95 focus:outline-none"
                            style="margin-right: 1px;">
                            Pay
                        </a>
                        <button
                            class="px-4 py-2 rounded-lg transition-transform duration-200 transform hover:scale-105 active:scale-95 focus:outline-none"
                            style="color: red;margin-right: 1px;">
                            Edit
                        </button>
                        <button
                            class="px-4 py-2 rounded-lg transition-transform duration-200 transform hover:scale-105 active:scale-95 focus:outline-none"
                            style="color: green;">
                            Details
                        </button>
                        <input type="checkbox" @click="prepareIdsForCheck(renew.id)">
                    </td>
                </tr>


            </tbody>

        </table>
    </div>
    <p v-if="no_renew" class="mt-4 text-gray-500">No results found.</p>
    <p class="mt-4 text-gray-500">Total :{{ getTotal() }}</p>
    <p class="mt-4 text-gray-500">Paid :{{ getPaid() }}</p>
</template>
<script>
import LoadingBox from '@/components/LoadingBox.vue';
// import RenewsDetailsCard from '@/components/RenewsDetailsCard.vue';
import { host } from '@/host';
import axios from 'axios';
import AlertBox from '@/components/AlertBox.vue';
import ExportExcel from '@/components/ExportExcel.vue';

export default {
    data() {
        return {
            customer_id: '',
            is_loading: false,
            renews: [],
            token: '',
            no_renew: false,
            ids: [],
            isAlertBox: false,
            title: '',
            message: '',
            action: '',
            searchQuery: '',
            sortKey: '',
            sortDirection: ''
        };
    },
    methods: {
        async search() {
            this.is_loading = true
            // let today = new Date();
            // let tomorrow = new Date();
            // today.setDate(today.getDate());
            // // today = today.toISOString().split('T')[0];
            // tomorrow.setDate(today.getDate() + 1);
            // today = today.toISOString().split('T')[0];

            // tomorrow = tomorrow.toISOString().split('T')[0];



            try {
                const response = await axios.get(`http://${host}:8000/api/get_unchecked_renews`, {
                    headers: {
                        Authorization: `Bearer ${this.token}`,
                    },
                });
                this.is_loading = false

                console.log(response.data);
                if (response.data.details == 'no result') {
                    this.no_renew = true;
                    this.renews = [];

                } else {
                    this.renews = response.data.details;
                }
                // return JSON.stringify(response.data); // You can return the response to be used later
            } catch (error) {
                this.is_loading = false

                console.error("There was an error during the search:", error);
            }
            console.log(this.getTotal())

            // console.log(this.getDateTime(this.renews[0].created_at))

        },

        prepareIdsForCheck(id) {
            let index = this.ids.indexOf(id);
            if (index !== -1) {
                this.ids.splice(index, 1);
            } else {
                this.ids.push(id);
            }

            console.log(this.ids)
        },

        check() {
            if (this.ids.length) {
                this.isAlertBox = true;
                this.title = 'Alert';
                this.message = 'We Are Redirecting you !!!';
                let token = localStorage.getItem('token');
                axios.put(`http://${host}:8000/api/check_renews/`,
                    {
                        data: this.ids
                    },
                    {
                        headers: {
                            Authorization: `Bearer ${token}`,
                            Accept: `application/json`
                        },
                    })
                    .then(response => {
                        console.log('Response:', response.data);
                        location.reload()
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
        },

        delete() {
            if (this.ids.length) {
                this.isAlertBox = true;
                this.title = 'Alert';
                this.message = 'We Are Redirecting you !!!';
                let token = localStorage.getItem('token');
                console.log(token)
                axios.delete(`http://${host}:8000/api/delete_renews_as_checked`, {
                    headers: {
                        Authorization: `Bearer ${token}`, // Include the token in headers
                        Accept: 'application/json'
                    },
                    data: {
                        data: this.ids // Wrap your IDs in an object with the key 'data'
                    }
                })
                    .then(response => {
                        console.log('Response:', response.data);
                        location.reload()
                    })
                    .catch(error => {
                        console.error('Error:', error.response ? error.response.data : error.message); // Handle error
                    });
            }
        },
        closeAlertBox() {
            this.isAlertBox = false
        },
        openAlertBox(action) {
            if (!this.ids.length) {
                alert('Don`t check again if you never select anything')
            } else {
                if (action == 'check') {
                    this.action = action;
                    this.isAlertBox = true
                    this.title = 'Confirm';
                    this.message = 'Are you Sure You Want Check These';
                }
                if (action == 'delete') {
                    this.action = action;
                    this.isAlertBox = true;
                    this.title = 'Confirm';
                    this.message = 'Are you Sure You Want Delete These';
                }
            }

        },
        getDateTime(data) {

            return data.split(' ');
        },
        getTotal() {
            let total = 0;
            for (let index = 0; index < this.renews.length; index++) {
                total += this.renews[index].total;
            }
            return total;
        },
        getPaid() {
            let paid = 0;
            for (let index = 0; index < this.renews.length; index++) {
                paid += this.renews[index].paid;
            }
            return paid;
        },
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

    },
    computed: {
        filteredSortedData() {
            // Filter based on the search query
            let filteredData = this.renews.filter((renew) => {
                return (
                    renew.employee_name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                    renew.customer_name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                    renew.service.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                    // renew.description.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                    renew.status.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                    (renew.note == null ? '' : renew.note).includes(this.searchQuery.toLowerCase())
                    // renew.note.includes(this.searchQuery.toLowerCase())
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
    mounted() {
        this.token = localStorage.getItem('token')
        this.search();
        // let total = 0;
        // for (let index = 0; index < this.renews.length; index++) {
        //     // total += this.renews[index].total
        // console.log(total)

        // }
    },
    components: {
        LoadingBox,
        AlertBox,
        ExportExcel
    }
};
</script>
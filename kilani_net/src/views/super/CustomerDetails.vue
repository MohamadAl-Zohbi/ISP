<template>
    <LoadingBox v-if="is_loading" />
    <AlertBox v-if="isAlertBox" :isOpen="true" :title="title" :message="message" :closeFunction="closeAlertBox"
        :check="check" :delete="delete" :action="action" />
    <table class="table-auto w-full bg-white shadow-md rounded" style="text-align: center;">
        <thead>
            <tr style="border-bottom: 1px solid black;">
                <th class="cursor-pointer p-4">Created</th>
                <th class="cursor-pointer p-4">From</th>
                <th class="cursor-pointer p-4">To</th>
                <th class="cursor-pointer p-4">Created By</th>
                <th class="cursor-pointer p-4">Service</th>
                <th class="cursor-pointer p-4">Status</th>
                <th class="cursor-pointer p-4">Total</th>
                <th class="cursor-pointer p-4">Paid</th>
                <th class="cursor-pointer p-4">Note</th>
                <th class="cursor-pointer p-4">Action <button
                        style="float: right; margin-right: 2%; color:blue;font-size: 15px;text-decoration: underline;"
                        @click="openAlertBox('check')">check</button>

                    <button
                        style="float: right; margin-right: 2%; color:blue;font-size: 15px;text-decoration: underline;"
                        @click="openAlertBox('delete')">delete</button>
                </th>

            </tr>
        </thead>
        <tbody>
            <tr v-for="(renew, index) in renews" :key="index"
                :class="['border-b', renew.checked_by_owner == 'checked' ? '' : 'bg-red-200', parseInt(renew.total) > parseInt(renew.paid) ? 'text-red-500' : '', 'hover:bg-gray-700', 'hover:!text-white']">

                <td class="p-1">dd-mm-yyyy<br />{{ new Date(renew.created_at).getDate() }}-{{ new
                    Date(renew.created_at).getMonth() + 1 }}-{{ new Date(renew.created_at).getFullYear()
                    }}</td>

                <td class="p-1 center">{{ new Date(renew.from).getDate() }}-{{ new
                    Date(renew.from).getMonth() + 1 }}-{{ new Date(renew.from).getFullYear()
                    }}</td>

                <td class="p-1">{{ new Date(renew.to).getDate() }}-{{ new
                    Date(renew.to).getMonth() + 1 }}-{{ new Date(renew.to).getFullYear()
                    }}</td>

                <td class="p-1">{{ renew.name }}</td>
                <td class="p-1">{{ renew.service }}</td>
                <td class="p-1">{{ renew.checked_by_owner }}</td>
                <td class="p-1">{{ renew.total }}</td>
                <td class="p-1">{{ renew.paid }}</td>
                <td class="p-1">{{ renew.note }}</td>
                <td class="p-1">
                    <a
                    :href="'/super/create-payment?id='+renew.id"
                        class="px-4 py-2 rounded-lg transition-transform duration-200 transform hover:scale-105 active:scale-95 focus:outline-none"
                        style="margin-right: 1px;">
                        Pay
                    </a>
                    <a
                    :href="'/super/edit-renew?id='+renew.id"

                        class="px-4 py-2 rounded-lg transition-transform duration-200 transform hover:scale-105 active:scale-95 focus:outline-none"
                        style="color: red;margin-right: 1px;">
                        Edit
                    </a>
                    <a
                    :href="'/super/renew-details?id='+renew.id"

                        class="px-4 py-2 rounded-lg transition-transform duration-200 transform hover:scale-105 active:scale-95 focus:outline-none"
                        style="color: green;">
                        Details
                    </a>
                    <input type="checkbox" @click="prepareIdsForCheck(renew.id)">
                </td>
            </tr>
            <p v-if="no_renew" class="mt-4 text-gray-500">No results found.</p>

        </tbody>
    </table>
</template>


<script>
import { host } from '@/host';
import LoadingBox from '@/components/LoadingBox.vue';
// import RenewsDetailsCard from '@/components/RenewsDetailsCard.vue';
import axios from 'axios';
import AlertBox from '@/components/AlertBox.vue';


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
            action: ''
        };
    },
    methods: {
        getParam() {
            let queryString = window.location.search;
            let urlParams = new URLSearchParams(queryString);
            let value = urlParams.get('id');

            return value;
        },

        async search(id) {
            this.is_loading = true
            // let token = localStorage.getItem('token');
            try {
                const response = await axios.get(`http://${host}:8000/api/get_customer_renews/${id}`, {
                    headers: {
                        Authorization: `Bearer ${this.token}`,
                    },
                    // params: {
                    //     search: searchQuery,
                    // },
                });
                this.is_loading = false

                if (response.data.details == 'no result') {
                    this.no_renew = true;
                    this.renews = [];

                } else {
                    this.renews = response.data.details;
                }
                return JSON.stringify(response.data); // You can return the response to be used later
            } catch (error) {
                this.is_loading = false

                console.error("There was an error during the search:", error);
            }
        },
        // getRenewPayments(renew_id) {

        //     axios.get('http://${host}:8000/api/get_payments/1', {
        //         headers: {
        //             Authorization: `Bearer ${this.token}`,
        //         },
        //     })
        //         .then(function (response) {
        //             // Handle success
        //         })
        //         .catch(function (error) {
        //             // Handle error
        //             console.error(error);
        //         })
        //         .finally(function () {
        //             // Always runs after .then() or .catch()
        //         });

        // },
        prepareIdsForCheck(id) {
            let index = this.ids.indexOf(id);
            if (index !== -1) {
                this.ids.splice(index, 1);
            } else {
                this.ids.push(id);
            }

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
        // showCustomerDetails(created_at, name, expiry, description, location, nationality, number, user, password) {
        //     this.created_at = created_at;
        //     this.name = name;
        //     this.expiry = expiry;
        //     this.description = description;
        //     this.location = location;
        //     this.nationality = nationality;
        //     this.number = number;
        //     this.user = user;
        //     this.password = password;
        //     this.isAlertBox = !this.isAlertBox;
        // },


    },
    mounted() {
        this.customer_id = this.getParam();
        this.token = localStorage.getItem('token');

        this.search(this.customer_id);

    },
    components: {
        LoadingBox,
        // RenewsDetailsCard
        AlertBox
    }
};

</script>
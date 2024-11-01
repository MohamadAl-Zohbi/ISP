<template>
    <LoadingBox v-if="is_loading" />
    <AlertBox v-if="isAlertBox" :isOpen="true" :title="title" :message="message" :closeFunction="closeAlertBox"
        :check="check" :delete="delete" :action="action" />
    <table class="table-auto w-full bg-white shadow-md rounded" style="text-align: center;">
        <thead>
            <tr style="border-bottom: 1px solid black;">
                <th class="cursor-pointer p-4">Created<br>yyyy-mm-dd</th>
                <th class="cursor-pointer p-4">From</th>
                <th class="cursor-pointer p-4">To</th>
                <th class="cursor-pointer p-4">Created By</th>
                <th class="cursor-pointer p-4">Customer Name</th>
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
                    <button
                        class="px-4 py-2 rounded-lg transition-transform duration-200 transform hover:scale-105 active:scale-95 focus:outline-none"
                        style="margin-right: 1px;">
                        Pay
                    </button>
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
    <p v-if="no_renew" class="mt-4 text-gray-500">No results found.</p>
    <p class="mt-4 text-gray-500">Total :{{ getTotal() }}</p>
    <p class="mt-4 text-gray-500">Paid :{{ getPaid() }}</p>
</template>


<script>
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
        async search() {
            this.is_loading = true
            let today = new Date();
            let tomorrow = new Date();
            today.setDate(today.getDate());
            // today = today.toISOString().split('T')[0];
            tomorrow.setDate(today.getDate() + 1);
            today = today.toISOString().split('T')[0];

            tomorrow = tomorrow.toISOString().split('T')[0];
            console.log(today)
            console.log(tomorrow)


            try {
                const response = await axios.get(`http://localhost:8000/api/get_renews_details_from_to`, {
                    headers: {
                        Authorization: `Bearer ${this.token}`,
                    },
                    params: {
                        from: today,
                        to: tomorrow
                    },
                });
                this.is_loading = false

                console.log(response.data);
                if (response.data.details == 'no result') {
                    this.no_renew = true
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
                axios.put('http://localhost:8000/api/check_renews/',
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
                axios.delete('http://localhost:8000/api/delete_renews_as_checked', {
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
        }
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
        AlertBox
    }
};
</script>
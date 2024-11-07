<template>

    <div v-if="opened" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900">{{ name }}</h3>
                <button @click="closeDialog" class="text-gray-500 hover:text-gray-900">
                    &times;
                </button>
            </div>
            <div class="mt-4">
                <p class="text-gray-600">Created At: {{ new Date(created_at).getDate() }}-{{ new
                    Date(created_at).getMonth() + 1 }}-{{ new Date(created_at).getFullYear()
                    }} / {{ new Date(created_at).getHours() }}:{{ new
                        Date(created_at).getMinutes() }}</p>
                <p class="text-gray-600">Expiry: {{ expiry }}</p>
                <p class="text-gray-600">Description: {{ description }}</p>
                <p class="text-gray-600">Location: {{ location }}</p>
                <p class="text-gray-600">Nationality: {{ nationality }}</p>
                <p class="text-gray-600">Number: {{ number }}</p>
                <p class="text-gray-600">User: {{ user }}</p>
                <p class="text-gray-600">Password: {{ password }}</p>
                <div style="display: inline-block;width: 88.27px;position: relative;">
                    <button @click="() => {
                        fast_charge = !fast_charge
                    }" class="transition-transform duration-200 transform hover:scale-105 active:scale-95 focus:outline-none"
                        style="float: left; background-color: white; color:blue;padding: 5px; border-radius: 5px;box-shadow: 1px 1px 10px 0px black;">
                        fastCharge
                    </button>
                    <div v-if="fast_charge"
                        style="position: absolute;box-shadow: 1px 1px 10px 0px black;right: -63px;top: 0px;padding: 5px;">
                        <div @click="renew('unpaid')" style="cursor: pointer;color: red;"
                            class="transition-transform duration-200 transform hover:scale-105 active:scale-95 focus:outline-none">
                            UnPaid</div>
                        <br>
                        <div @click="renew('paid')" style="cursor: pointer;color: green;"
                            class="transition-transform duration-200 transform hover:scale-105 active:scale-95 focus:outline-none">
                            Paid
                        </div>
                    </div>

                </div>
            </div>



            <!-- <div class="mt-6 flex justify-end space-x-4">
                <button @click="closeDialog" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                    Cancel
                </button>
                <button @click="confirmAction" class="bg-gray-700 text-white px-4 py-2 rounded-md hover:bg-gray-900">
                    Confirm
                </button>
            </div> -->
        </div>
    </div>
</template>

<script>
import LiteSuccessBox from '@/components/LiteSuccessBox.vue';

import axios from 'axios';
export default {
    props: {
        isOpen: {
            type: Boolean,
            default: true,
        },
        created_at: {
            type: String,
        },
        name: {
            type: String,
        },
        expiry: {
            type: String,
        },
        description: {
            type: String,
        },
        location: {
            type: String,
        },
        nationality: {
            type: String,
        },
        number: {
            type: String,
        },
        user: {
            type: String,
        },
        password: {
            type: String,
        },
        id: {
            type: Number,
        },

        closeFunction: {
            type: Function
        },
        isDone: {
            type: Function
        },
    },

    data() {
        return {
            opened: this.isOpen,
            fast_charge: false,
            success: false,
            done: false,

        }
    },
    methods: {
        closeDialog() {
            this.opened = !this.opened // Emits the 'close' event to the parent component
            this.closeFunction()
        },
        confirmAction() {
            alert("Confirmed!");
            this.closeDialog(); // Call close after confirming
        },
        getNextMonthDate() {
            let expiry = this.expiry;
            // Add one month
            let date = new Date(this.expiry);
            expiry = expiry.toString().split('T')[0].split('-'); // month 0 -> 11
            console.log(expiry)
            console.log(parseInt(expiry[2]), parseInt(this.getLastDayOfMonth(expiry[0], `${parseInt(expiry[1]) + 2}`)))
            console.log(`${parseInt(expiry[1]) + 1}`)
            console.log('hello: ', this.getLastDayOfMonth(expiry[0], `${parseInt(expiry[1]) + 1}`));
            if (parseInt(expiry[2]) <= parseInt(this.getLastDayOfMonth(expiry[0], `${parseInt(expiry[1]) + 1}`))) {
                date.setMonth(expiry[1]) // next month (to)
                return date.toISOString().split('T')[0];
            } else {
                date.setDate(this.getLastDayOfMonth(expiry[0], `${parseInt(expiry[1]) + 1}`));
                date.setMonth(expiry[1]);
                return date.toISOString().split('T')[0];
            }

        },

        getLastDayOfMonth(year, month) {
            // Month is 0-based in JavaScript, so January is 0, December is 11
            return new Date(year, month, 0).getDate();
        },
        async getInfo() {
            console.log(this.id);
            this.closeDialog();
            let token = localStorage.getItem('token');
            try {
                const response = await axios.get(`http://localhost:8000/api/get_customer_details_for_fast_charge/` + this.id, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                });
                this.success = true;
                return response.data;

            } catch (error) {
                console.error("There was an error during the search:", error);
            }

        },
        async renew(action /*paid or unpaid parameter */) {

            let info = await this.getInfo();
            let paid = 0;
            if (action == 'unpaid') {
                paid = 0;
            } else {
                paid = info.total
            }
            console.log(info);
            let to = this.getNextMonthDate();
            let token = localStorage.getItem('token');
            // try {
            //     const response = await axios.post('http://localhost:8000/api/create_renew', {
            //         from: this.expiry,
            //         to: to,
            //         cheked_by_owner: 'waiting',
            //         total: info.total,
            //         paid: paid,
            //         service_id: info.id,
            //         customer_id: this.id,
            //         note: 'fast charge',
            //     }, {
            //         headers: {
            //             Authorization: `Bearer ${token}`
            //         }
            //     });
            //     this.is_loading = false
            //     this.done = true
            //     console.log('Post created:', response.data);
            // } catch (error) {
            //     this.is_loading = false
            //     this.is_closed_warning = true
            //     this.details = response.data.details
            //     console.error("There was an error creating the post:", error);
            // };

            axios.post('http://localhost:8000/api/create_renew', {
                from: this.expiry,
                to: to,
                cheked_by_owner: 'waiting',
                total: info.total,
                paid: paid,
                service_id: info.id,
                customer_id: this.id,
                note: 'fast charge',
            }, {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            })
                .then(response => {
                    this.isDone();
                    
                    console.log('Response:', response.data);
                    // location.reload()
                })
                .catch(error => {
                    console.error('Error:', error);
                });

        }
    },
    components: {
        LiteSuccessBox
    }
};
</script>
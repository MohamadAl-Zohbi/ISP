<template>
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">

            <div class="flex justify-between items-center">
                <button @click="closeDialog" class="text-gray-500 hover:text-gray-900">
                    &times;
                </button>
            </div>
            <div class="mt-4">
                <input style="box-shadow: 0px 0px 5px 0px black;border-radius: 5px; margin: 2px" type="text" @keypress="(event) => {
                    const char = String.fromCharCode(event.keyCode); // Get the pressed key
                    if (!/^\d$/.test(char) && char != '.') {  // Check if the character is not a digit
                        event.preventDefault();  // Prevent non-digit input
                    }
                }" placeholder="amount"  
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />

                <textarea
              
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    style="box-shadow: 0px 0px 5px 0px black;border-radius: 5px; margin: 2px"
                    placeholder="note"></textarea>

            </div>



            <div class="mt-6 flex justify-end space-x-4">
                <button @click="closeDialog" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                    Cancel
                </button>
                <button @click="confirmAction" class="bg-gray-700 text-white px-4 py-2 rounded-md hover:bg-gray-900">
                    Confirm
                </button>
            </div>
        </div>
    </div>
</template>
<script>

import { host } from '@/host';
import axios from 'axios';

export default {
    data() {
        return {
            note:'',
            amount:''
        };
    },
    props: {
        id: {
            type: Number
        },
        note:{
            type:String
        },
        amount:{
            type:Number
        },
        close:{
            type:Function
        }
    },
    methods: {

        async submit() {
            console.log(this.total)
            let date1 = new Date(this.expiry);
            let date2 = new Date(this.to);
            if (this.from == '' || date1 >= date2 || this.to == '' || this.service == '') {
                return '';
            }

            if (this.paid > 0) {
                if (this.who == '') {
                    alert('Who is the payer')
                    return '';
                }
            }

            this.is_loading = true;
            let token = localStorage.getItem('token');
            let service_id = document.getElementById('service').value.split(',')[1];
            try {
                const response_renew = await axios.post(`http://${host}:8000/api/create_renew`, {
                    from: this.expiry,
                    to: this.to,
                    cheked_by_owner: 'waiting',
                    total: this.total,
                    paid: 0,
                    service_id: service_id,
                    customer_id: this.customer.id,
                    note: this.note,
                }, {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                });
                this.is_loading = false

                console.log('Post created:', response_renew.data);
                if (this.paid > 0) {
                    try {
                        // console.log(this.paid)
                        let response_payment = await axios.post(`http://${host}:8000/api/create_payment/` + response_renew.data.id, {
                            amount: this.paid,
                            phone_number: this.number,
                            description: this.description,
                            who: this.who,
                            payment_method: 'cash',
                            // renew_id: response_renew.data.id,
                        }, {
                            headers: {
                                Authorization: `Bearer ${token}`
                            }
                        });
                        this.is_loading = false

                        console.log('Post created:', response_payment.data);


                    } catch (error) {
                        this.is_loading = false
                        this.is_closed_warning = true
                        this.details = response.data.details

                        console.error("There was an error creating the post:", error);
                    }
                }

            } catch (error) {
                this.is_loading = false
                this.is_closed_warning = true
                this.details = response.data.details

                console.error("There was an error creating the post:", error);
            }

            location.replace('manage-customers?search=')
        },
        closeDialog() {
            this.close()
        },
        confirmAction() {
            // alert("Confirmed!");
            if (this.action == 'check')
                this.check()

            if (this.action == 'delete')
                this.delete()

            if (this.action == 'payment')
                this.delete(this.id)

        },
    },
    async mounted() {

    },
};
</script>

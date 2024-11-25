<template>

    <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50">
        <div>
            <input type="text" @keypress="(event) => {
                const char = String.fromCharCode(event.keyCode); // Get the pressed key
                if (!/^\d$/.test(char) && char != '.') {  // Check if the character is not a digit
                    event.preventDefault();  // Prevent non-digit input
                }
            }" v-model="total" required
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
        </div>
        <form @submit.prevent="submitForm" class="space-y-4">
            <button type="submit" @click="submit()"
                class="  px-4 bg-red-600 text-white font-semibold rounded-md shadow hover:bg-gray-700 transition duration-200">
                Edit
            </button>
        </form>
    </div>

</template>
<script>
import { host } from '@/host';
import axios from 'axios';

export default {
    data() {
        return {

        };
    },
    props: {
        id: {
            type: Number
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



    },
    async mounted() {

    },
};
</script>

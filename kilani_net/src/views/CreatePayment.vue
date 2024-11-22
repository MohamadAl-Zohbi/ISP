<template>
    <LoadingBox v-if="is_loading" />
    <div class="p-4" style="display: inline-block;position: fixed;right: 0px; top: 50px">
        <transition name="slide-right" @after-enter="startTimeout">
            <div v-if="success" class="bg-green-100 border border-green-300 text-green-700 p-4 rounded mb-4">
                <p>Item successfully deleted!</p>
            </div>
        </transition>
    </div>
    <div class="max-w-md mx-auto p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Payment Form</h2>
        <div>
            <label for="customer" class="block text-sm font-medium text-gray-700">Customer:</label>
            <input type="text" v-model="name"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                readonly>
        </div>
        <br>
        <form @submit.prevent="submitForm" class="space-y-4">
            <div>
                <label for="expiry" class="block text-sm font-medium text-gray-700">Expiry mm/dd/yyyy:</label>
                <input type="date" v-model="expiry" readonly
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
            </div>

            <div>
                <label for="payment-method" class="block text-sm font-medium text-gray-700">Payment Method:</label>
                <select v-model="method" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option disabled value="">Select an option</option>
                    <option value="cash">cash</option>
                    <option value="wish_money">wish</option>
                    <option value="other">other</option>

                </select>
            </div>
            <br>
            <div>
                <label for="total" class="block text-sm font-medium text-gray-700">Total: $$</label>
                <input type="text" v-model="total" disabled
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
            </div>
            <div>
                <label for="paid" class="block text-sm font-medium text-gray-700">Paid: $$</label>
                <input type="text" v-model="paid" disabled
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
            </div>
            <div>
                <label for="amount" class="block text-sm font-medium text-gray-700">Amount: $$</label>
                <input type="text" @keypress="(event) => {
                    const char = String.fromCharCode(event.keyCode); // Get the pressed key
                    if (!/^\d$/.test(char) && char != '.') {  // Check if the character is not a digit
                        event.preventDefault();  // Prevent non-digit input
                    }
                }" v-model.number="amount" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
            </div>




            <div>
                <label for="who" class="block text-sm font-medium text-gray-700">Who*:</label>
                <input type="text" v-model="who" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
            </div>
            <div>
                <label for="number" class="block text-sm font-medium text-gray-700">Number:</label>
                <input type="text" v-model="number"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
            </div>
            <div>
                <label for="note" class="block text-sm font-medium text-gray-700">Note:</label>
                <input type="text" v-model="description"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
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
            total: '',
            paid: '',
            amount: '',
            description: '',
            who: '',
            number: '',
            expiry: '',
            method: 'cash',
            name: '',
            is_loading: false,
            success: false,
        }
    },
    methods: {
        getParam() {
            let queryString = window.location.search;
            let urlParams = new URLSearchParams(queryString);
            let value = urlParams.get('id');
            return value;
        },
        async getInfo(id) {
            let token = localStorage.getItem('token');
            try {
                this.is_loading = true;

                const response = await axios.get(`http://${host}:8000/api/get_renew_for_payment/` + id, {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                });
                this.is_loading = false
                console.log('Post created:', response.data);
                let customer = response.data.customer;
                let renew = response.data.renew;
                this.name = customer.name;
                this.expiry = customer.expiry;
                this.total = renew.total;
                this.paid = renew.paid;
                this.amount = renew.total - renew.paid;
            } catch (error) {
                this.is_loading = false
                // this.is_closed_warning = true
                console.error("There was an error creating the post:", error);
            }
        },
        startTimeout() {
            // Hide the message after 2 seconds
            setTimeout(() => {
                this.success = false;
                location.replace('/')
            }, 1000);
        },
        async submit() {
            if (!this.who || !this.amount || this.amount <= 0 ) {
                alert('wrong info')
                return false
            }

            if ((this.paid + this.amount) > this.total ) {
                alert('you are paying more then the total please check your info')
                return false
            }
            let token = localStorage.getItem('token');
            // if (this.amount > this.total) {
            //     return false;
            // }
            try {
                this.is_loading = true;
                const payment_response = await axios.post(`http://${host}:8000/api/create_payment/` + this.getParam(),
                    {
                        amount: this.amount,
                        phone_number: this.number,
                        description: this.description,
                        who: this.who,
                        payment_method: this.method,

                    }, {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                });
                this.is_loading = false

                console.log('Post created:', payment_response.data);
                if (payment_response.data.status == false) {
                    alert(payment_response.data.details)
                }
                this.success = true

            } catch (error) {
                this.is_loading = false


                console.error("There was an error creating the post:", error);
            }

        }
    },
    mounted() {
        console.log(this.getParam())
        this.getInfo(this.getParam())
    },
    components: {
        LoadingBox
    }
}
</script>
<style scoped>
/* Slide-in from the right and slide-out to the right */
.slide-right-enter-active,
.slide-right-leave-active {
    transition: transform 2s ease;
}

.slide-right-enter {
    transform: translateX(100%);
}

.slide-right-leave-to {
    transform: translateX(100%);
}
</style>
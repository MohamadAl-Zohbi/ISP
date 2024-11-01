<template>
    <LoadingBox v-if="is_loading" />

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

                const response = await axios.get('http://localhost:8000/api/get_renew_for_payment/' + id, {
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
        async submit() {
            if(!this.who || !this.amount || this.amount <=0){
                alert('wrong info')
                return false
            }
            
            let token = localStorage.getItem('token');
            if (this.amount > this.total) {
                return false;
            }
            try {
                this.is_loading = true;
                const payment_response = await axios.post('http://localhost:8000/api/create_payment/' + this.getParam(), 
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
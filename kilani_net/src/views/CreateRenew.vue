<template>
    <LoadingBox v-if="is_loading" />
    <!-- <div v-if="is_chosen" class="max-w-md mx-auto p-6 bg-white rounded-lg shadow-md"
        style="height: 500px; overflow-y: auto">
        <h2 class="text-2xl font-bold mb-6 text-center">Choose The Name</h2>
        <input v-model="searchQuery" type="text" placeholder="Search..." class="border p-2 mb-4 w-full" />

        <div v-for="(customer, index) in filteredSortedData" :key="customer.id" @click="chooseName(index)"
            class="p-4 mb-2 bg-gray-100 rounded-lg shadow-md" style="cursor: pointer;">
            <p class="text-lg font-medium text-gray-700">{{ customer.name }}</p>
        </div>
    </div> -->
    <div class="max-w-md mx-auto p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Renewal Form</h2>
        <div>
            <label for="customer" class="block text-sm font-medium text-gray-700">Customer:</label>
            <input type="text" v-model="name" required
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                readonly>
        </div>
        <br>
        <form @submit.prevent="submitForm" class="space-y-4">
            <div>
                <label for="fromDate" class="block text-sm font-medium text-gray-700">From Date:mm/dd/yyyy</label>
                <input type="date" @change="getTotal(service)" v-model="expiry" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
            </div>

            <div>
                <label for="to" class="block text-sm font-medium text-gray-700">To Date:</label>
                <input type="date" @change="getTotal(service)" v-model="to" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
            </div>

            <div>
                <label for="service" class="block text-sm font-medium text-gray-700">Service:</label>
                <select id="service" @change="(event) => {
                    getTotal(event.target.value)
                }" v-model="service" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option disabled value="">Select an option</option>
                    <option v-for="service in services" :key="service.id" :value="[service.price, service.id]">{{
                        service.service }}
                    </option>
                </select>
            </div>
            <br>
            <div>
                <label for="total" class="block text-sm font-medium text-gray-700">Total Amount: $$</label>
                <input type="text" @keypress="(event) => {
                    const char = String.fromCharCode(event.keyCode); // Get the pressed key
                    if (!/^\d$/.test(char) && char != '.') {  // Check if the character is not a digit
                        event.preventDefault();  // Prevent non-digit input
                    }
                }" v-model.number="total" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
            </div>

            <div>
                <label for="note" class="block text-sm font-medium text-gray-700">Note:</label>
                <input type="text" v-model="note"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
            </div>
            <h2 class="text-1xl font-bold mb-6 text-center">Payment</h2>

            <div>
                <label for="paid" class="block text-sm font-medium text-gray-700">Payment Amount: $$</label>
                <input type="text" @keypress="(event) => {
                    const char = String.fromCharCode(event.keyCode); // Get the pressed key
                    if (!/^\d$/.test(char) && char != '.') {  // Check if the character is not a digit
                        event.preventDefault();  // Prevent non-digit input
                    }
                }" v-model.number="paid"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
            </div>
            <div>
                <label for="who" class="block text-sm font-medium text-gray-700">Who:</label>
                <input type="text" v-model="who"
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

        <!-- <div v-if="submitted" class="mt-6 p-4 border rounded bg-gray-100">
            <h3 class="font-semibold">Renewal Summary</h3>
            <p><strong>From Date:</strong> {{ fromDate }}</p>
            <p><strong>To Date:</strong> {{ toDate }}</p>
            <p><strong>Total Amount:</strong> {{ total }}</p>
            <p><strong>Service:</strong> {{ service }}</p>

        </div> -->
    </div>
</template>

<script>
import axios from 'axios';
import LoadingBox from '@/components/LoadingBox.vue';
export default {
    data() {
        return {
            // fromDate: this.getTodayDate(),
            toDate: this.getNextMonthDate(),
            searchQuery: '',
            name: '',
            total: 0.00,
            expiry: '',
            service: '',
            description: ' ',
            note: ' ',
            to: '',
            who: '',
            customer: '',
            payOfWho: '',
            number: '',
            paid: 0.00,
            // customers: [

            // ],
            services: [
                // { id: 1, service: "2MB", total: 20 }
            ],
            is_loading: false,
            is_chosen: true
        };
    },
    methods: {
        // getTodayDate() {
        //     const expiry = this.customer.expiry;
        //     // Format date as YYYY-MM-DD
        //     // return today.toISOString().split('T')[0];
        //     return expiry;
        // },
        getNextMonthDate() {
            const today = new Date();
            // Add one month
            const nextMonthDate = new Date(today.setMonth(today.getMonth() + 1));
            // Format date as YYYY-MM-DD
            return nextMonthDate.toISOString().split('T')[0];
        },
        // submitForm() {
        //     this.submitted = true;

        // const renewalData = {
        //     fromDate: this.fromDate,
        //     toDate: this.toDate,
        //     total: this.total,
        //     service: this.service,
        //     payAmount: this.payAmount,
        //     whoPay: this.whoPay,
        //     payOfWho: this.payOfWho,
        // };

        // Example: Send data to the server
        // axios.post('http://localhost:8000/api/renewals', renewalData)
        //   .then(response => {
        //     console.log('Renewal submitted:', response.data);
        //   })
        //   .catch(error => {
        //     console.error('Error submitting renewal:', error);
        //   });
        // },
        // chooseName(index) {
        //     this.customer = this.customers[index].name;

        //     console.log(this.customer, index);
        //     this.is_chosen = false
        // },
        getTotal(value) {
            if (!value) {
                return false;
            }
            let date1 = new Date(this.expiry);
            let date2 = new Date(this.to);

            let timeDifference = date2 - date1;
            let daysDifference = timeDifference / (1000 * 60 * 60 * 24);
            console.log(daysDifference);
            //  20$ ===> 30day
            //  ??  <===  1
            this.total = (daysDifference * parseInt(value) / 30).toFixed(2);
            console.log(document.getElementById('service').value.split(',')[1])
            return true;
        },
        getParam() {
            let queryString = window.location.search;
            let urlParams = new URLSearchParams(queryString);
            let value = urlParams.get('id');

            return value;
        },
        async submit() {
            let date1 = new Date(this.expiry);
            let date2 = new Date(this.to);
            if (this.from == '' || date1 >= date2 || this.to == '' || this.service == '' || !this.getTotal(document.getElementById('service').value)) {
                return '';
            }

            if (this.paid > 0) {
                if (this.who == '') {
                    return '';
                }
            }

            this.is_loading = true;
            let token = localStorage.getItem('token');
            let service_id = document.getElementById('service').value.split(',')[1];
            try {
                const response_renew = await axios.post('http://localhost:8000/api/create_renew', {
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
                        let response_payment = await axios.post('http://localhost:8000/api/create_payment', {
                            amount: this.paid,
                            phone_number: this.number,
                            description: this.description,
                            who: this.who,
                            payment_method: 'cash',
                            renew_id: response_renew.data.id,
                        }, {
                            headers: {
                                Authorization: `Bearer ${token}`
                            }
                        });
                        this.is_loading = false

                        console.log('Post created:', response_payment.data);
                        if (this.paid != 0) {
                            alert('ss')
                        }

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
        }

    },
    computed: {
        filteredSortedData() {
            // Filter based on the search query
            let filteredData = this.customers.filter((customer) => {
                return (
                    customer.name.toLowerCase().includes(this.searchQuery.toLowerCase())
                );
            });

            // Sort the filtered data
            // if (this.sortKey) {
            //     filteredData.sort((a, b) => {
            //         let result = 0;
            //         if (a[this.sortKey] > b[this.sortKey]) result = 1;
            //         if (a[this.sortKey] < b[this.sortKey]) result = -1;
            //         return result * this.sortDirection;
            //     });
            // }

            return filteredData;
        },

    },
    async mounted() {
        this.is_loading = true
        let token = localStorage.getItem('token');
        try {
            const response = await axios.get(`http://localhost:8000/api/get_customer/${this.getParam()}`, {
                headers: {
                    Authorization: `Bearer ${token}`,
                }
            });
            this.is_loading = false


            console.log(response.data);
            this.customer = response.data.details;
            this.name = this.customer.name;
            this.expiry = this.customer.expiry;
            let date = new Date(this.customer.expiry);
            date.setMonth(date.getMonth() + 1);
            this.to = date.toISOString().split('T')[0];
            console.log(this.to);
        } catch (error) {
            this.is_loading = false

            console.error("There was an error during the search:", error);
        };

        try {
            this.is_loading = true

            const response = await axios.get(`http://localhost:8000/api/show_all_services`, {
                headers: {
                    Authorization: `Bearer ${token}`,
                }
            });
            this.is_loading = false


            console.log(response.data);
            this.services = response.data.details
            console.log(document.getElementById('service').value)

        } catch (error) {
            this.is_loading = false

            console.error("There was an error during the search:", error);
        };

    },
    components: {
        LoadingBox
    }
};
</script>

<style scoped>
/* Additional styles can go here if needed */
</style>
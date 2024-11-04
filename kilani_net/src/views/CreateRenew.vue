<template>
    <LoadingBox v-if="is_loading" />

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
                <input type="date" @change="getNextMonthDate()" v-model="expiry" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
            </div>

            <div>
                <label for="to" class="block text-sm font-medium text-gray-700">To Date:</label>
                <input type="date" @change="getTotal(service)" v-model="to" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
            </div>
            <!-- number of days  -->
            <div>
                <label for="days" class="block text-sm font-medium text-gray-700">Days</label>
                <input type="text" v-model="number_of_days" readonly
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
                }" v-model="total" required
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

        <!-- <div v-if="true" class="mt-6 p-4 border rounded bg-gray-100">
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
            name: '',
            total: 0.00,
            expiry: '',
            service: '',
            description: ' ',
            note: ' ',
            to: '',
            who: '',
            customer: '',
            number: '',
            number_of_days: '',
            paid: 0.00,
            services: [],
            is_loading: false,
        };
    },
    methods: {

        getNextMonthDate() {
            let expiry = this.expiry;
            // Add one month
            let date = new Date(this.expiry);
            // expiry = expiry.toString().split('T')[0].split('-'); // month 0 -> 11
            // console.log(expiry)
            // console.log(parseInt(expiry[2]), parseInt(this.getLastDayOfMonth(expiry[0], `${parseInt(expiry[1]) + 2}`)))
            // // let check_year = this.checkYear(expiry[0], expiry[1]);
            // // // console.log(check_year)
            // // if (check_year) {
            // //     expiry[0] = check_year.split()[0];
            // // }
            // console.log(`${parseInt(expiry[1]) + 1}`)
            // console.log('hello: ', this.getLastDayOfMonth(expiry[0], `${parseInt(expiry[1]) + 1}`));
            // if (parseInt(expiry[2]) <= parseInt(this.getLastDayOfMonth(expiry[0], `${parseInt(expiry[1]) + 2}`))) {
            //     date.setMonth(expiry[1]) // next month (to)
            //     this.to = date.toISOString().split('T')[0];
            // } else {
            //     date.setDate(this.getLastDayOfMonth(expiry[0], `${parseInt(expiry[1]) + 2}`));
            //     date.setMonth(expiry[1]);
            //     this.to = date.toISOString().split('T')[0];
            // }
      
            date.setMonth(10);
            console.log(date.toISOString().split('T')[0])
        },
        checkYear(year, month) {
            if (month == '12') {
                return `${parseInt(year) + 1} ${0}`;
            }
            return false;
        },

        getLastDayOfMonth(year, month) {
            // Month is 0-based in JavaScript, so January is 0, December is 11
            return new Date(year, month, 0).getDate();
        },
        getTotal(value) {
            if (!value) {
                return false;
            }
            let date1 = new Date(this.expiry);
            let date2 = new Date(this.to);

            let timeDifference = date2 - date1;
            let daysDifference = timeDifference / (1000 * 60 * 60 * 24);

            console.log(daysDifference)
            //  20$ ===> 30day
            //  ??  <===  1
            this.total = (daysDifference * parseInt(value) / 30).toFixed(2);
            return true;
        },
        getParam() {
            let queryString = window.location.search;
            let urlParams = new URLSearchParams(queryString);
            let value = urlParams.get('id');

            return value;
        },
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
            let service_id = document.getElementById('service').value.split(',')[1];// 203-dd-fdde [202,dd,fdde]  dd
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
                        let response_payment = await axios.post('http://localhost:8000/api/create_payment/' + response_renew.data.id, {
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
        }

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


            // console.log(response.data);
            this.customer = response.data.details;
            this.name = this.customer.name;
            this.expiry = this.customer.expiry;
            let date = new Date(this.customer.expiry);
            date.setMonth(date.getMonth() + 1);
            this.to = date.toISOString().split('T')[0];
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


            // console.log(response.data);
            this.services = response.data.details

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
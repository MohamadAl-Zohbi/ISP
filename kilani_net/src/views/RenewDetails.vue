<template>
    <div class="p-4" style="display: inline-block;position: fixed;right: 0px; top: 50px">
        <transition name="slide-right" @after-enter="startTimeout">
            <div v-if="success" class="bg-green-100 border border-green-300 text-green-700 p-4 rounded mb-4">
                <p>Item successfully deleted!</p>
            </div>
        </transition>
    </div>

    <LoadingBox v-if="is_loading" />

    <PaymentCard v-for="payment in payments" :id="payment.id" :name="name" :amount="payment.amount" :from="from"
        :to="to" :service="service" :created_at="payment.created_at" :note="payment.description" />
    <p v-if="!payments.length" class="mt-4 text-gray-500">No results found.</p>

</template>
<script>
import LoadingBox from '@/components/LoadingBox.vue';
import PaymentCard from '@/components/PaymentCard.vue';
import axios from 'axios';
export default {
    data() {
        return {
            payments: '',
            service: '',
            from: '',
            to: '',
            name: '',
            is_loading: false,
            token: localStorage.getItem('token'),
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
        startTimeout() {
            // Hide the message after 2 seconds
            setTimeout(() => {
                this.success = false;
            }, 1000);
        },
        async getPayments() {
            this.is_loading = true;
            try {
                const response = await axios.get(`http://localhost:8000/api/get_payments/` + this.getParam(), {
                    headers: {
                        Authorization: `Bearer ${this.token}`,
                    },
                });

                console.log(response.data);
                this.payments = response.data.details;
                // console.log(this.payments);
                this.service = response.data.service;
                this.from = response.data.renew.from;
                this.to = response.data.renew.to;
                this.name = response.data.name;

            } catch (error) {
                console.error("There was an error during the search:", error);
            }

            this.is_loading = false;
        },
        deletePayment(id) {
            axios.delete('http://localhost:8000/api/delete_payment/'+id,
                {
                    headers: {
                        Authorization: `Bearer ${this.token}`,
                        Accept: `application/json`
                    },
                })
                .then(response => {
                    console.log('Response:', response.data);
                    this.success = true;
                    this.payments.slice(response.data.details,1);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    },
    mounted() {
        this.getPayments()
        this.deletePayment(31)
    },
    components: {
        PaymentCard,
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
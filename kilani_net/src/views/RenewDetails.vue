<template>
    <LoadingBox v-if="is_loading" />

    <PaymentCard v-for="payment in payments" :id="payment.id" :name="name" :amount="payment.amount" :from="from"
        :to="to" :service="service" :created_at="payment.created_at" :note="payment.description"/>
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
            is_loading: false
        }
    },
    methods: {
        getParam() {
            let queryString = window.location.search;
            let urlParams = new URLSearchParams(queryString);
            let value = urlParams.get('id');
            return value;
        },
        async getPayments() {
            this.is_loading = true;
            let token = localStorage.getItem('token');
            try {
                const response = await axios.get(`http://localhost:8000/api/get_payments/` + this.getParam(), {
                    headers: {
                        Authorization: `Bearer ${token}`,
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
    },
    mounted() {
        this.getPayments()
    },
    components: {
        PaymentCard,
        LoadingBox
    }
}
</script>
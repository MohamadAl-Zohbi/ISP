<template>
    <LoadingBox v-if="is_loading" />
    <PaymentCard id="1" name="Mohamad Saliba" total="50" paid="40" from="12/03/2024" to="13/09/2025" service="2Mb"
        created_at="12/09/2024" />
</template>
<script>
import LoadingBox from '@/components/LoadingBox.vue';
import PaymentCard from '@/components/PaymentCard.vue';
import axios from 'axios';
export default {
    data() {
        return {
            payments: '',
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
                this.services = response.data.details;

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
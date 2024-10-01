<template>
    <LoadingBox v-if="is_loading" />
    <div v-for="(renew, index) in renews" :key="index">
        {{ getRenewPayments(renew.id) }}
    </div>
</template>


<script>
import LoadingBox from '@/components/LoadingBox.vue';
import RenewsDetailsCard from '@/components/RenewsDetailsCard.vue';
import axios from 'axios';


export default {
    data() {
        return {
            customer_id: '',
            is_loading: false,
            renews: [],
            token:''
        };
    },
    methods: {
        getParam() {
            let queryString = window.location.search;
            let urlParams = new URLSearchParams(queryString);
            let value = urlParams.get('id');

            return value;
        },

        async search(id) {
            this.is_loading = true
            // let token = localStorage.getItem('token');
            try {
                const response = await axios.get(`http://localhost:8000/api/get_customer_renews_from_to/${id}`, {
                    headers: {
                        Authorization: `Bearer ${this.token}`,
                    },
                    // params: {
                    //     search: searchQuery,
                    // },
                });
                this.is_loading = false

                console.log(response.data);
                this.renews = response.data.details;
                return JSON.stringify(response.data); // You can return the response to be used later
            } catch (error) {
                this.is_loading = false

                console.error("There was an error during the search:", error);
            }
        },
        getRenewPayments(renew_id) {

            axios.get('http://localhost:8000/api/get_payments/1',{
             headers: {
                Authorization: `Bearer ${this.token}`,
            },})
                .then(function (response) {
                    // Handle success
                    console.log(response.data);
                })
                .catch(function (error) {
                    // Handle error
                    console.error(error);
                })
                .finally(function () {
                    // Always runs after .then() or .catch()
                    console.log('Request completed');
                });

        }

        // showCustomerDetails(created_at, name, expiry, description, location, nationality, number, user, password) {
        //     this.created_at = created_at;
        //     this.name = name;
        //     this.expiry = expiry;
        //     this.description = description;
        //     this.location = location;
        //     this.nationality = nationality;
        //     this.number = number;
        //     this.user = user;
        //     this.password = password;
        //     this.isOpenDetailsCustomer = !this.isOpenDetailsCustomer;
        // },


    },
    mounted() {
        this.customer_id = this.getParam();
        this.token = localStorage.getItem('token');
        this.search(this.customer_id);

    },
    components: {
        LoadingBox,
        RenewsDetailsCard
    }
};

</script>
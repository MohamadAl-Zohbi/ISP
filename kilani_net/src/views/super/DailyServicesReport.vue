<template>
    <LoadingBox v-if="is_loading" />

    <table class="table-auto w-full bg-white shadow-md rounded" style="text-align: center;">
        <thead>
            <tr style="border-bottom: 1px solid black;">
                <th v-for="result in results"  class="cursor-pointer p-4">{{ result.service }}</th>
            </tr>
        </thead>
        <tbody>
            <tr class="border-b">
                <td v-for="result in results"  class="p-1">{{ result.count }}</td>
            </tr>
        </tbody>
    </table>
    <p v-if="!results" class="mt-4 text-gray-500">No results found.</p>

</template>


<script>
import LoadingBox from '@/components/LoadingBox.vue';
import { host } from '@/host';
// import RenewsDetailsCard from '@/components/RenewsDetailsCard.vue';
import axios from 'axios';


export default {
    data() {
        return {
            is_loading: false,
            results:[]
        };
    },
    methods: {
        async getTodayRenew() {
            this.is_loading = true;
            let today = new Date();
            let tomorrow = new Date();
            today = today.toISOString().split('T')[0];
            tomorrow.setDate(tomorrow.getDate() + 1);
            tomorrow = tomorrow.toISOString().split('T')[0];
            console.log(today);
            console.log(tomorrow);
            let token = localStorage.getItem('token')
            try {
                const response = await axios.get(`http://${host}:8000/api/get_services_renews_from_to`, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                    params: {
                        from: today,
                        to: tomorrow,
                    },
                });
                console.log(response.data)
                this.results = response.data.details;
                this.is_loading = false
            } catch (error) {

                console.log(error)
            }



        },




    },
    mounted() {
        this.getTodayRenew()

    },
    components: {
        LoadingBox,
    }
};

</script>
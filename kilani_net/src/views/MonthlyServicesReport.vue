<template>
    <LoadingBox v-if="is_loading" />
    <div>
        <label for="fromDate" class="block text-sm font-medium text-gray-700">From Date:mm/dd/yyyy</label>
        <input type="date" v-model="date1"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
    </div>

    <div>
        <label for="to" class="block text-sm font-medium text-gray-700">To Date:</label>
        <input type="date" v-model="date2"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
    </div>

    <table class="table-auto w-full bg-white shadow-md rounded" style="text-align: center;">
        <thead>
            <tr style="border-bottom: 1px solid black;">
                <th v-for="result in results" class="cursor-pointer p-4">{{ result.service }}</th>
            </tr>
        </thead>
        <tbody>
            <tr class="border-b">
                <td v-for="result in results" class="p-1">{{ result.count }}</td>
            </tr>
        </tbody>
    </table>
</template>


<script>
import LoadingBox from '@/components/LoadingBox.vue';
// import RenewsDetailsCard from '@/components/RenewsDetailsCard.vue';
import axios from 'axios';


export default {
    data() {
        return {
            is_loading: false,
            results: [],
            date1: this.getDate1(),
            date2: this.getDate2(),
        };
    },
    methods: {
        async getTodayRenew() {
            this.is_loading = true;
            // let date2 = new Date();

            // date1 = date1.toISOString().split('T')[0];
            // date2.setDate(date2.getDate() + 1);
            // date2 = date2.toISOString().split('T')[0];
            // console.log(date1)
            // console.log(date2)
            // console.log(this.is_loading)

            // 5/09
            // 5/10


            let token = localStorage.getItem('token')
            try {
                const response = await axios.get('http://localhost:8000/api/get_renews_from_to', {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                    params: {
                        from: this.date1,
                        to: this.date2,
                    },
                });
                console.log(response.data)
                this.results = response.data.details;
                this.is_loading = false
            } catch (error) {

                console.log(error)
            }



        },
        getDate1() {
            let date1 = new Date();
            date1.setDate(6);
            date1.setMonth(date1.getMonth());
            date1 = date1.toISOString().split('T')[0];
            console.log(date1)
            return date1
        },
        getDate2() {
            let date2 = new Date();
            date2.setDate(6);
            date2.setMonth(date2.getMonth() + 1);
            date2 = date2.toISOString().split('T')[0];
            console.log(date2)
            return date2
        }




    },
    mounted() {
        this.getTodayRenew()

    },
    components: {
        LoadingBox,
    }
};

</script>
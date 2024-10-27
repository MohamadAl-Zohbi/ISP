<template>
    <LoadingBox v-if="is_loading" />
    <div>
        <div style="text-align: center;">
            <div style="border-radius: 5px; border: 1px solid;display: inline-block;">
                <label for="fromDate" class="text-sm font-medium text-gray-700" style="margin-right: 20px;">From Date:
                    mm/dd/yyyy</label>
                <input type="date" v-model="date1"
                    class="mt-1   border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />

            </div>
            <div style="border-radius: 5px; border: 1px solid;display: inline-block; margin: 10px;">
                <label for="to" class=" text-sm font-medium text-gray-700" style="margin-right: 20px;">To Date:
                    mm/dd/yyyy</label>
                <input type="date" v-model="date2"
                    class="mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />

            </div>
        </div>
        <button @click="getMonthlyServices()"
            class="w-full py-2 px-4 bg-gray-600 text-white font-semibold rounded-md shadow hover:bg-gray-700 transition duration-200">
            Search
        </button>
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
    <p v-if="results.length === 0" class="mt-4 text-gray-500">No results found.</p>

</template>


<script>
import LoadingBox from '@/components/LoadingBox.vue';
import { search } from '@/utils';
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
        async getMonthlyServices() {
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
console.log(this.date1,this.date2)

            let token = localStorage.getItem('token')
            try {
                const response = await axios.get('http://localhost:8000/api/get_renews_details_from_to', {
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
                if (this.results == 'no result') {
                    this.results = []
                }

            } catch (error) {

                console.log(error)
            }



        },
        getDate1() {
            let date1 = new Date();
            date1.setDate(5);
            date1.setMonth(date1.getMonth() - 1);
            date1 = date1.toISOString().split('T')[0];
            console.log(date1)
            return date1
        },
        getDate2() {
            let date2 = new Date();
            date2.setDate(6); // 6 the 6 day will not be because the interval between [5:6[
            date2.setMonth(date2.getMonth());
            date2 = date2.toISOString().split('T')[0];
            console.log(date2)
            return date2
        }




    },
    mounted() {
        this.getMonthlyServices()

    },
    components: {
        LoadingBox,
    }
};

</script>
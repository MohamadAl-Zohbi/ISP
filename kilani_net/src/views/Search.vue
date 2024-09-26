    <template>
        <LoadingBox v-if="is_loading" />

        <div class="container mx-auto mt-4">
            <!-- Search Input -->
            <input v-model="searchQuery" type="text" placeholder="Search..." class="border p-2 mb-4 w-full" autofocus />

            <!-- Data Table -->
            <table class="table-auto w-full bg-white shadow-md rounded">
                <thead>
                    <tr>
                        <th @click="sortBy('name')" class="cursor-pointer p-4">Created</th>
                        <th @click="sortBy('name')" class="cursor-pointer p-4">Name</th>
                        <th @click="sortBy('age')" class="cursor-pointer p-4">Expiry</th>
                        <th @click="sortBy('city')" class="cursor-pointer p-4">Description</th>
                        <th @click="sortBy('city')" class="cursor-pointer p-4">Location</th>
                        <th @click="sortBy('city')" class="cursor-pointer p-4">Nationality</th>
                        <th @click="sortBy('city')" class="cursor-pointer p-4">Number</th>
                        <th @click="sortBy('city')" class="cursor-pointer p-4">User</th>
                        <th @click="sortBy('city')" class="cursor-pointer p-4">Password</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="background-color: red" v-for="(customer, index) in filteredSortedData" :key="index"
                        class="border-b">

                        <td class="p-4">dd-mm-yyyy <br />{{ new Date(customer.created_at).getDate() }}-{{ new Date(customer.created_at).getMonth() + 1 }}-{{ new Date(customer.created_at).getFullYear() }}</td>


                        <td class="p-4">{{ customer.age }}</td>
                        <td class="p-4">{{ customer.city }}</td>
                        <td class="p-4">{{ customer.city }}</td>
                        <td class="p-4">{{ customer.city }}</td>
                        <td class="p-4">{{ customer.city }}</td>
                        <td class="p-4">{{ customer.city }}</td>
                        <td class="p-4">{{ customer.city }}</td>
                        <td class="p-4">{{ customer.city }}</td>
                    </tr>
                </tbody>
            </table>
            <!-- No Results Found -->
            <p v-if="filteredSortedData.length === 0" class="mt-4 text-gray-500">No results found.</p>
        </div>
    </template>

<script>
import LoadingBox from '@/components/LoadingBox.vue';
import { search } from '@/utils.js';
export default {
    data() {
        return {
            searchQuery: '', // Search query for filtering
            sortKey: '', // Key by which to sort
            sortDirection: 1, // 1 for ascending, -1 for descending
            is_loading: true,
            test: '',
            customers: [

            ],
        };
    },
    computed: {
        filteredSortedData() {
            // Filter based on the search query
            let filteredData = this.customers.filter((customer) => {
                return (
                    customer.name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                    customer.city.toLowerCase().includes(this.searchQuery.toLowerCase())
                );
            });

            // Sort the filtered data
            if (this.sortKey) {
                filteredData.sort((a, b) => {
                    let result = 0;
                    if (a[this.sortKey] > b[this.sortKey]) result = 1;
                    if (a[this.sortKey] < b[this.sortKey]) result = -1;
                    return result * this.sortDirection;
                });
            }

            return filteredData;
        },
    },
    methods: {

        // Method to set the sort key and toggle the sort direction
        sortBy(key) {
            if (this.sortKey === key) {
                // Toggle sort direction
                this.sortDirection *= -1;
            } else {
                // Set new sort key
                this.sortKey = key;
                this.sortDirection = 1;
            }
        },
        getParam() {
            let queryString = window.location.search;
            let urlParams = new URLSearchParams(queryString);
            let value = urlParams.get('search');

            return value;
        },
        async search() {
            this.is_loading = true;
            this.test = JSON.parse((await search(this.getParam())));
            console.log(this.test.details[2])
            this.customers = this.test.details;

            this.is_loading = false;
        }

    },
    mounted() {
        this.searchQuery = this.getParam();
        this.search()
    },
    components: {
        LoadingBox
    }
};

</script>

<style scoped>
.container {
    max-width: 800px;
}

.table-auto {
    width: 100%;
    text-align: center;
}

.cursor-pointer {
    cursor: pointer;
}
</style>
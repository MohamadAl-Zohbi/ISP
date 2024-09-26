<template>
  <div class="container mx-auto mt-4">
    <!-- Search Input -->
    <input
      v-model="searchQuery"
      type="text"
      placeholder="Search..."
      class="border p-2 mb-4 w-full"
    />

    <!-- Data Table -->
    <table class="table-auto w-full bg-white shadow-md rounded">
      <thead>
        <tr>
          <th @click="sortBy('name')" class="cursor-pointer p-4">Name</th>
          <th @click="sortBy('age')" class="cursor-pointer p-4">Age</th>
          <th @click="sortBy('city')" class="cursor-pointer p-4">City</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(person, index) in filteredSortedData" :key="index" class="border-b">
          <td class="p-4">{{ person.name }}</td>
          <td class="p-4">{{ person.age }}</td>
          <td class="p-4">{{ person.city }}</td>
        </tr>
      </tbody>
    </table>

    <!-- No Results Found -->
    <p v-if="filteredSortedData.length === 0" class="mt-4 text-gray-500">No results found.</p>
  </div>
</template>

<script>
export default {
  data() {
    return {
      searchQuery: '', // Search query for filtering
      sortKey: '', // Key by which to sort
      sortDirection: 1, // 1 for ascending, -1 for descending
      people: [
        { name: 'John Doe', age: 28, city: 'New York' },
        { name: 'Jane Smith', age: 34, city: 'San Francisco' },
        { name: 'Michael Brown', age: 25, city: 'Los Angeles' },
        { name: 'Emily Johnson', age: 42, city: 'Chicago' },
      ],
    };
  },
  computed: {
    // Filter and sort the data based on search query and sort settings
    filteredSortedData() {
      // Filter based on the search query
      let filteredData = this.people.filter((person) => {
        return (
          person.name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
          person.city.toLowerCase().includes(this.searchQuery.toLowerCase())
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
  },
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

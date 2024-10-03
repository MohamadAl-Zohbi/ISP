<template>
    <div class="max-w-md mx-auto p-6 bg-white rounded-lg shadow-md">
      <h2 class="text-2xl font-bold mb-6 text-center">Renewal Form</h2>
      <form @submit.prevent="submitForm" class="space-y-4">
        <div>
          <label for="fromDate" class="block text-sm font-medium text-gray-700">From Date:</label>
          <input
            type="date"
            v-model="fromDate"
            required
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
          />
        </div>
  
        <div>
          <label for="toDate" class="block text-sm font-medium text-gray-700">To Date:</label>
          <input
            type="date"
            v-model="toDate"
            required
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
          />
        </div>
  
        <div>
          <label for="total" class="block text-sm font-medium text-gray-700">Total Amount:</label>
          <input
            type="number"
            v-model.number="total"
            required
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
          />
        </div>
  
        <div>
          <label for="service" class="block text-sm font-medium text-gray-700">Service:</label>
          <input
            type="text"
            v-model="service"
            required
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
          />
        </div>
  
        <div>
          <label for="payAmount" class="block text-sm font-medium text-gray-700">Payment Amount:</label>
          <input
            type="number"
            v-model.number="payAmount"
            required
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
          />
        </div>
  
        <div>
          <label for="whoPay" class="block text-sm font-medium text-gray-700">Who Pays:</label>
          <input
            type="text"
            v-model="whoPay"
            required
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
          />
        </div>
  
        <div>
          <label for="payOfWho" class="block text-sm font-medium text-gray-700">Pay Of Who:</label>
          <select
            v-model="payOfWho"
            required
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
          >
            <option disabled value="">Select an option</option>
            <option v-for="person in people" :key="person.id" :value="person.name">{{ person.name }}</option>
          </select>
        </div>
  
        <button
          type="submit"
          class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-md shadow hover:bg-indigo-700 transition duration-200"
        >
          Submit
        </button>
      </form>
  
      <div v-if="submitted" class="mt-6 p-4 border rounded bg-gray-100">
        <h3 class="font-semibold">Renewal Summary</h3>
        <p><strong>From Date:</strong> {{ fromDate }}</p>
        <p><strong>To Date:</strong> {{ toDate }}</p>
        <p><strong>Total Amount:</strong> {{ total }}</p>
        <p><strong>Service:</strong> {{ service }}</p>
        <p><strong>Payment Amount:</strong> {{ payAmount }}</p>
        <p><strong>Who Pays:</strong> {{ whoPay }}</p>
        <p><strong>Pay Of Who:</strong> {{ payOfWho }}</p>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        fromDate: this.getTodayDate(),
        toDate: this.getNextMonthDate(),
        total: 0,
        service: '',
        payAmount: 0,
        whoPay: '',
        payOfWho: '',
        submitted: false,
        people: [
          { id: 1, name: 'John Doe' },
          { id: 2, name: 'Jane Smith' },
          { id: 3, name: 'Bob Johnson' },
          // Add more options as needed
        ],
      };
    },
    methods: {
      getTodayDate() {
        const today = new Date();
        // Format date as YYYY-MM-DD
        return today.toISOString().split('T')[0];
      },
      getNextMonthDate() {
        const today = new Date();
        // Add one month
        const nextMonthDate = new Date(today.setMonth(today.getMonth() + 1));
        // Format date as YYYY-MM-DD
        return nextMonthDate.toISOString().split('T')[0];
      },
      submitForm() {
        this.submitted = true;
  
        const renewalData = {
          fromDate: this.fromDate,
          toDate: this.toDate,
          total: this.total,
          service: this.service,
          payAmount: this.payAmount,
          whoPay: this.whoPay,
          payOfWho: this.payOfWho,
        };
  
        // Example: Send data to the server
        // axios.post('http://localhost:8000/api/renewals', renewalData)
        //   .then(response => {
        //     console.log('Renewal submitted:', response.data);
        //   })
        //   .catch(error => {
        //     console.error('Error submitting renewal:', error);
        //   });
      },
    },
  };
  </script>
  
  <style scoped>
  /* Additional styles can go here if needed */
  </style>
  
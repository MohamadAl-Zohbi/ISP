<template>
    <div v-if="opened" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900">{{ name }}</h3>
                <button @click="closeDialog" class="text-gray-500 hover:text-gray-900">
                    &times;
                </button>
            </div>
            <div class="mt-4">
                <p class="text-gray-600">Created At: {{ new Date(created_at).getDate() }}-{{ new
                    Date(created_at).getMonth() + 1 }}-{{ new Date(created_at).getFullYear()
                    }} / {{ new Date(created_at).getHours() }}:{{ new
                        Date(created_at).getMinutes() }}</p>
                <p class="text-gray-600">Expiry: {{ expiry }}</p>
                <p class="text-gray-600">Description: {{ description }}</p>
                <p class="text-gray-600">Location: {{ location }}</p>
                <p class="text-gray-600">Nationality: {{ nationality }}</p>
                <p class="text-gray-600">Number: {{ number }}</p>
                <p class="text-gray-600">User: {{ user }}</p>
                <p class="text-gray-600">Password: {{ password }}</p>
                <button style="float: right; background-color: white; color:red;padding: 5px; border-radius: 5px;box-shadow: 1px 1px 10px 0px black;">
                 fastCharge
                </button>
            </div>



            <!-- <div class="mt-6 flex justify-end space-x-4">
                <button @click="closeDialog" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                    Cancel
                </button>
                <button @click="confirmAction" class="bg-gray-700 text-white px-4 py-2 rounded-md hover:bg-gray-900">
                    Confirm
                </button>
            </div> -->
        </div>
    </div>
</template>

<script>
export default {
    props: {
        isOpen: {
            type: Boolean,
            default: true,
        },
        created_at: {
            type: String,
        },
        name: {
            type: String,
        },
        expiry: {
            type: String,
        },
        description: {
            type: String,
        },
        location: {
            type: String,
        },
        nationality: {
            type: String,
        },
        number: {
            type: String,
        },
        user: {
            type: String,
        },
        password: {
            type: String,
        },

        closeFunction: {
            type: Function
        },
    },

    data() {
        return {
            opened: this.isOpen
        }
    },
    methods: {
        closeDialog() {
            this.opened = !this.opened // Emits the 'close' event to the parent component
            this.closeFunction()
        },
        confirmAction() {
            alert("Confirmed!");
            this.closeDialog(); // Call close after confirming
        },
    },
};
</script>
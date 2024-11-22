<template>
    <div v-if="opened" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-red-900">{{ title }}</h3>
                <button @click="closeDialog" class="text-gray-500 hover:text-gray-900">
                    &times;
                </button>
            </div>
            <div class="mt-4">
                <p class="text-gray-600">{{ message }}</p>
            </div>



            <div class="mt-6 flex justify-end space-x-4">
                <button @click="closeDialog" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                    Cancel
                </button>
                <button @click="confirmAction" class="bg-gray-700 text-white px-4 py-2 rounded-md hover:bg-gray-900">
                    Confirm
                </button>
            </div>
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
        title: {
            type: String,
        },
        action: {
            type: String,
        },
        message: {
            type: String,
        },
        closeFunction: {
            type: Function
        },
        check: {
            type: Function
        },
        delete: {
            type: Function
        },
        id: {
            type: Number
        }
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
            // alert("Confirmed!");
            if (this.action == 'check')
                this.check()

            if (this.action == 'delete')
                this.delete()

            if (this.action == 'payment')
                this.delete(this.id)

        },
    },
};
</script>
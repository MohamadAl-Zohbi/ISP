<template>
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">

            <div class="flex justify-between items-center">
                <button @click="closeDialog" class="text-gray-500 hover:text-gray-900">
                    &times;
                </button>
            </div>
            <div class="mt-4">
                <input v-model="_amount" style="box-shadow: 0px 0px 5px 0px black;border-radius: 5px; margin: 2px"
                    type="text" @keypress="(event) => {
                        const char = String.fromCharCode(event.keyCode); // Get the pressed key
                        if (!/^\d$/.test(char) && char != '.') {  // Check if the character is not a digit
                            event.preventDefault();  // Prevent non-digit input
                        }
                    }" placeholder="amount"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />

                <textarea v-model="_note"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    style="box-shadow: 0px 0px 5px 0px black;border-radius: 5px; margin: 2px"
                    placeholder="note"></textarea>

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

import { host } from '@/host';
import axios from 'axios';

export default {
    data() {
        return {
            _note: '',
            _amount: ''
        };
    },
    props: {
        id: {
            type: Number
        },
        note: {
            type: String
        },
        amount: {
            type: Number
        },
        close: {
            type: Function
        }
    },
    methods: {

        async submit() {
            if (!this._amount || this._amount <= 0) {
                alert('wrong info')
                return false
            }


            let token = localStorage.getItem('token');

            try {
                this.is_loading = true;
                const payment_response = await axios.put(`http://${host}:8000/api/update_payment/` + this.id,
                    {
                        amount: this._amount,
                        description: this._note,
                    }, {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                });

                alert('done')
                location.reload();

            } catch (error) {
                this.is_loading = false


                console.error("There was an error creating the post:", error);
            }

        },
        closeDialog() {
            this.close()
        },
        confirmAction() {
            this.submit()
        },
    },
    async mounted() {
        this._note = this.note
        this._amount = this.amount
    },
};
</script>

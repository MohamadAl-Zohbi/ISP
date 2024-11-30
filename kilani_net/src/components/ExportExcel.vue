<template>
    <span>
        <button style="color: green;"
            class="px-4 py-2 rounded-lg transition-transform duration-200 transform hover:scale-105 active:scale-95 focus:outline-none"
            @click="click">excel</button>

    </span>
</template>

<script>
import { host } from '@/host';
export default {
    props: {
        headers: {
            type: Array,
        },
        contents: {
            type: Array,
        },

    },

    data() {
        return {

        }
    },
    methods: {
        async click() {
            for (let index = 0; index < this.contents.length; index++) {
                if (!this.contents[index].created_at.includes("T")) {
                    break;
                }
                this.contents[index].created_at = this.contents[index].created_at.split('T')[0] + " " + this.contents[index].created_at.split('T')[1].split('.')[0];
                // this.contents[index].expiry = this.contents[index].expiry.split('-')[2] + '-' + this.contents[index].expiry.split('-')[1] + '-' + this.contents[index].expiry.split('-')[0]
                // this.contents[index].created_at = 'sjsj';
                // .toISOString().split('T')[0]

            }
            const data =
            {
                headers: this.headers,
                contents: this.contents
            };

            try {
                console.log("Sending data to server...");
                const response = await fetch(`http://${host}/kilani-net/back_end/excel.php`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                });
                console.log(response);
                if (!response.ok) {
                    throw new Error(`HTTP Error: ${response.status}`);
                }

                console.log("Response received...");
                const blob = await response.blob();

                // تنزيل ملف Excel
                const url = window.URL.createObjectURL(blob);
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', 'excel.xlsx');
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                console.log("Download successful!");
            } catch (error) {
                console.error("Error during file generation:", error);
            }
        }
    },
}
</script>
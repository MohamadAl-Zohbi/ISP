<template>
    <div
        style="margin:20px auto;max-width: 350px;box-sizing: border-box;box-shadow: 4px 4px 10px 0px black;border-radius: 5px;">
        <div>
            <img style="margin: auto;" width="150" src="../assets/cloudsp.jpg" alt="CloudSp">
            <pre style="text-align: center;">{{ id }}</pre>

            <div>
                <!-- <div>
                    <p><b>Name:</b> <span>Mohamad</span></p>
                    <p><b>Total:</b> <span>50$</span></p>
                    <p><b>Paid:</b> <span>40$</span></p>
                    <p><b>Amount:</b> <span>10$</span></p>
                </div> -->
                <h1 style="text-align: center;font-size: 17px;font-weight: bold;">{{ name }}</h1>
                <table style="width: 350px;">
                    <tbody>
                        <tr>
                            <td>Amount</td>
                            <td colspan="2"><b>{{ amount }}$</b></td>
                        </tr>

                        <tr>
                            <td>service</td>
                            <td colspan="2">{{ service }}</td>
                        </tr>
                        <tr>
                            <td>from</td>
                            <td colspan="2"><span>{{ from }}<sub>yyyy/mm/dd</sub></span></td>
                        </tr>
                        <tr>
                            <td>to</td>
                            <td colspan="2"><span>{{ to }}<sub>yyyy/mm/dd</sub></span></td>
                        </tr>
                        <tr>
                            <td colspan="3">{{ note }}</td>
                        </tr>
                    </tbody>
                </table>
                <!-- <p style="padding: 10px;">
                    <span>
                        <b>Note:</b>
                    </span>
                </p> -->
                <!-- <div style="padding: 5px;">
                    <p>
                        <b style="">from: </b><span>10/01/2024<sub>dd/mm/yyyy</sub></span>

                    </p>
                    <p>
                        <b style="">to: </b><span>10/01/2024<sub>dd/mm/yyyy</sub></span>

                    </p>
                </div> -->
                <div style="text-align: center;">
                    <pre><p>CloudSp شكرا لاستخدامكم انترنت</p>TEL: 70 577 959</pre>

                </div>
                <div style="text-align: center; font-weight: bold; font-size: 13px;">
                    <!-- 30/10/2024 &nbsp;14:23:21 -->
                    <!-- {{ created_at.toString().split('T')[0] }} &nbsp;{{ created_at.toString().split('T')[1].split('.')[0] }} -->
                    {{ new Date(created_at).toLocaleString("en-US", { timeZone: "Asia/Beirut" }) }}
                    <!-- <div style="display: inline-block; float: left; margin: 0px 0px" >ccc</div> -->
                    <!-- <div style="display: inline-block; float: right; margin: 0px 0px" >ccc</div> -->
                </div>
            </div>
        </div>
        <br>
        <div class="action">
            <button style="background-color: white; width: 33.33%; box-shadow: 1px 1px 10px 0px black; color: orange"
                class="px-4 py-2 rounded-lg transition-transform duration-200 transform hover:scale-105 active:scale-95 focus:outline-none">Edit</button>
            <button @click="openAlertBox(id)" style="background-color: white; width: 33.33%; box-shadow: 1px 1px 10px 0px black; color: red"
                class="px-4 py-2 rounded-lg transition-transform duration-200 transform hover:scale-105 active:scale-95 focus:outline-none">Delete</button>
            <button @click="print()"
                style="background-color: white; width: 33.33%; box-shadow: 1px 1px 10px 0px black; color: green"
                class="px-4 py-2 rounded-lg transition-transform duration-200 transform hover:scale-105 active:scale-95 focus:outline-none">Print</button>


        </div>
    </div>

</template>
<script>
export default {
    data() {
        return {

        };
    },
    props: {
        name: {
            type: String,
            required: true
        },
        note: {
            type: String,
            required: true
        },
        amount: {
            type: Number,
            required: true
        },
        service: {
            type: String,
            required: true
        },
        from: {
            type: String,
            required: true
        },
        to: {
            type: String,
            required: true
        },
        created_at: {
            type: String,
            required: true
        },
        id: {
            type: Number,
            required: true
        },
        open: {
            type: Function,
        }
    },
    methods: {
        print() {
            let data = {
                name: this.name,
                note: this.note,
                amount: this.amount,
                service: this.service,
                from: this.from,
                to: this.to,
                created_at: this.created_at,
                id: this.id
            };
            sessionStorage.setItem('data', JSON.stringify(data));
            window.open(
                "print-payment",  // URL
                "PopupWindow",          // Window name
                "width=400,height=400,resizable=yes,scrollbars=yes"
            );
        },
        openAlertBox(id){
            this.open(id);
        }
    },
    mounted() {

    },

};
</script>
<style scoped>
* {
    padding: 0px;
    margin: 0px;
}

td {
    text-align: center;
    border-bottom: 1px solid;
}
</style>
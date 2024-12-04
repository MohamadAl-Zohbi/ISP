<template>
    <div
        style="margin:20px auto;max-width: 350px;box-sizing: border-box;box-shadow: 4px 4px 10px 0px black;border-radius: 5px;">
        <div>
            <img style="margin: auto;" width="150" src="../assets/cloudsp.jpg" alt="CloudSp">
            <pre style="text-align: center;">{{ id }}</pre>

            <div>
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
                <div style="text-align: center;">
                    <pre><p>CloudSp شكرا لاستخدامكم انترنت</p>TEL: 70 577 959</pre>

                </div>
                <div style="text-align: center; font-weight: bold; font-size: 13px;">
                    {{ new Date(created_at).toLocaleString("en-US", { timeZone: "Asia/Beirut" }) }}
                </div>
            </div>
        </div>
        <br>

    </div>

</template>
<script>
export default {
    data() {
        return {
            name: '',
            note: '',
            amount: '',
            service: '',
            from: '',
            to: '',
            created_at: '',
            id: '',
        };
    },

    methods: {
        print() {
            window.open(
                "print-payment",  // URL
                "PopupWindow",          // Window name
                "width=300,height=300,resizable=yes,scrollbars=yes"
            );
        }
    },
    mounted() {
        window.print()
        let data = JSON.parse(sessionStorage.getItem('data'));
        this.name = data.name;
        this.note = data.note;
        this.amount = data.amount;
        this.service = data.service;
        this.from = data.from;
        this.to = data.to;
        this.created_at = data.created_at;
        this.id = data.id;
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
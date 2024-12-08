import './assets/main.css'

import { createApp } from 'vue'
import App from './App.vue'
import App1 from './App1.vue'
import router from './router'
import axios from 'axios'
import { host } from './host'
import LogIn from './views/LogIn.vue'
import NotFound from './NotFound.vue'
const path = location.pathname;
async function check() {
    try {
        const response = await axios.get(`http://${host}:8000/api/check`, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`,
            },
        });

        console.log(response.data.rank);
        return response.data.rank;
    } catch (error) {
        console.error("There was an error during the search:", error);
        return false;
    }
}
const rank = await check();
let app;
if (path != '/login' && path != '/') {
    if (rank == 'super') {
        app = createApp(App)
    } else if (rank == 'admin') {
        app = createApp(App1)
    } else {
        // alert('you have a problem in the main js file try to check the permissions logic');
        app = createApp(NotFound)
    }
} else {
    // alert('else')
    app = createApp(LogIn)
}





app.use(router)

app.mount('#app')

import './bootstrap';
import {createApp} from 'vue';
import App from './App.vue'
import router from "./router";
import store from "../store";
// add axios
import VueAxios from 'vue-axios';
import axios from 'axios';
const app = createApp(App)
    .use(router)
    .use(store)
    .use(VueAxios, axios);

axios.interceptors.response.use(function (response) {
    // Any status code that lie within the range of 2xx cause this function to trigger
    // Do something with response data
    return response;
}, function (error) {
    if (error?.response?.status === 401) {
        store.dispatch('auth/logout').then(() => {
            router.push({name: "productIndex"});
        });
    }
    return Promise.reject(error);
});


app.mount("#app");

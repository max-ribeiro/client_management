import "./bootstrap";
import router from "./router/router";
import { createApp } from "vue";
import axios from 'axios';

import App from "./App.vue";

const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
}

createApp(App).use(router).mount("#app");
import "./bootstrap";
import router from "./router/router";
import { createApp } from "vue";
import axios from 'axios';

import App from "./App.vue";

const app = createApp(App);

const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
}

app
    .use(router)
    .mount("#app");
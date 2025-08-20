import "./bootstrap";
import router from "./router/router";
import { createApp } from "vue";
import axios from 'axios';

import App from "./App.vue";
import { initFlowbite } from "flowbite";

const app = createApp(App);

const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
}
router.afterEach(() => {
  setTimeout(() => initFlowbite(), 0) // garante que o DOM já foi renderizado
})

app
    .use(router)
    .mount("#app");
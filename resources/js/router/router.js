import { createRouter, createWebHistory } from 'vue-router';
import Login from '../components/Login.vue';
import Clients from '../components/Client/Clients.vue';
import Reports from '../components/Reports/Reports.vue';

const routes = [
    {path: '/', component: Login},
    {path: '/clients', component: Clients},
    {path: '/reports', component: Reports}
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
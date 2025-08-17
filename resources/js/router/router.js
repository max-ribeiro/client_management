import { createRouter, createWebHistory } from 'vue-router';
import Login from '../components/Login.vue';
import Clients from '../components/Client/Clients.vue';
import Charts from '../components/Charts/Charts.vue';
import NotFound from '../components/System/NotFound.vue';

const routes = [
    {path: '/', component: Login},
    {path: '/clients', component: Clients},
    {path: '/charts', component: Charts},
    { path: '/:pathMatch(.*)*', name: 'NotFound', component: NotFound },

];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
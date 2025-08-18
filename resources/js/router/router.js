import { createRouter, createWebHistory } from 'vue-router';
import Login from '../components/Login.vue';
import Clients from '../components/Client/Clients.vue';
import Charts from '../components/Charts/Charts.vue';
import NotFound from '../components/System/NotFound.vue';
import Forbidden from '../components/System/Forbidden.vue';
import Logout from '../components/Logout.vue';

const routes = [
    { path: '/', component: Login },
    { path: '/logout', component: Logout },
    { path: '/clients', component: Clients, meta: { requiresAuth: true } },
    { path: '/charts', component: Charts, meta: { requiresAuth: true } },
    { path: '/:pathMatch(.*)*', name: 'NotFound', component: NotFound },
    { path: '/forbidden', name: 'Forbidden', component: Forbidden },

];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('token');

    // se a rota exige autenticação e não tem token
    if (to.meta.requiresAuth && !token) {
        return next('/forbidden');
    }

    // se usuário já está logado e tenta acessar login
    if (to.path === '/' && token) {
        return next('/clients');
    }

    next();
});

export default router;

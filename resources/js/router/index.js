import {createMemoryHistory, createRouter, createWebHistory} from 'vue-router'

import HomeView from '../views/HomeView.vue'
import RegisterView from "../views/RegisterView.vue";
import LoginView from "../views/LoginView.vue";
import DashboardView from "../views/DashboardView.vue";
import WorldView from "../views/WorldView.vue";

const routes = [
    {
        path: '/',
        name: 'Home',
        component: HomeView,
        meta: { requiresAuth: true }
    },
    {
        path: '/register',
        name: 'Register',
        component: RegisterView,
        meta: { requiresGuest: true }
    },
    {
        path: '/login',
        name: 'Login',
        component: LoginView,
        meta: { requiresGuest: true }
    },
    {
        path: '/dashboard',
        name: 'Dashboard',
        component: DashboardView,
        meta: { requiresAuth: true }
    },
    {
        path: '/worlds/:id',
        name: 'world.show',
        component: WorldView,
        meta: { requiresAuth: true }
    }
]

export const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach(async (to, from, next) => {
    const {useAuthStore} = await import('../auth');
    const authStore = useAuthStore();

    const token = localStorage.getItem('auth_token');
    if (token && !authStore.user) {
        await authStore.fetchUser();
    }

    const isAuthenticated = !!authStore.user;

    if (to.meta.requiresAuth && !isAuthenticated) {
        return next('/login');
    }

    if (to.meta.requiresGuest && isAuthenticated) {
        return next('/dashboard');
    }

    next();
})

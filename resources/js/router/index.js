import {createMemoryHistory, createRouter, createWebHistory} from 'vue-router'

import HomeView from '../views/HomeView.vue'
import RegisterView from "../views/RegisterView.vue";
import LoginView from "../views/LoginView.vue";
import DashboardView from "../views/DashboardView.vue";

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
        meta: { requiresAuth: true }
    },
    {
        path: '/login',
        name: 'Login',
        component: LoginView,
        meta: { requiresAuth: true }
    },
    {
        path: '/dashboard',
        name: 'Dashboard',
        component: DashboardView,
        meta: { requiresAuth: true }
    },
]

export const router = createRouter({
    history: createWebHistory(),
    routes,
})

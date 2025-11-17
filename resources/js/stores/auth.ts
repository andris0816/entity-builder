import { defineStore } from "pinia";
import { ref } from "vue";
import { useRouter } from "vue-router";
import {apiFetch} from "../utils/api";
import {ValidationErrors} from "../types/validation-errors";

interface User {
    id: bigint;
    name: string;
    email: string;
    email_verified_at: string;
    created_at: string;
    updated_at: string;
}

export const useAuthStore = defineStore('auth', () => {
    const user = ref<User | null>(null);
    const token = ref<string | null>(localStorage.getItem('auth_token'));
    const loading = ref(false);
    const error = ref<ValidationErrors>(null);
    const router = useRouter();

    const login = async (email: string, password: string) => {
        loading.value = true;
        error.value = {};
        const response = await apiFetch('/login', {
            method: 'POST',
            body: JSON.stringify({ email, password }),
        });

        const data = await response.json();

        if (!response.ok) {
            if (response.status === 422 || response.status === 401) {
                error.value = data.errors || {};
            } else {
                console.error('Server error:', data.message || data);
            }
            return;
        }

        localStorage.setItem('auth_token', data.token);
        token.value = data.token;
        user.value = data.user;

        await router.push('/dashboard');

        loading.value = false;
    };

    const register = async (name: string, email: string, password: string, passwordConfirmation: string) => {
        loading.value = true;
        error.value = {};
        const response = await apiFetch('/register', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                name,
                email,
                password,
                password_confirmation: passwordConfirmation
            }),
        });

        const data = await response.json();

        if (!response.ok) {
            if (response.status === 422 || response.status === 401) {
                error.value = data.errors || {};
            } else {
                console.error('Server error:', data.message || data);
            }
            return;
        }

        localStorage.setItem('auth_token', data.token);
        token.value = data.token;
        user.value = data.user;

        await router.push('/dashboard');
    };

    const logout = async () => {
        if (token.value) {
            await apiFetch('/logout', {
                method: 'POST',
            });
        }

        localStorage.removeItem('auth_token');
        token.value = null;
        user.value = null;
        await router.push('/login');
    };

    const fetchUser = async () => {
        const token = localStorage.getItem('auth_token');
        if (!token) {
            user.value = null;
            return;
        }

        try {
            const response = await apiFetch('/user');
            user.value = response.ok ? await response.json() : null;
        } catch {
            user.value = null;
        }
    };

    const clearAuth = () => {
        user.value = null;
        token.value = null;
        localStorage.removeItem('auth_token');
    }

    return {
        user,
        loading,
        error,
        login,
        register,
        logout,
        fetchUser,
        clearAuth,
        apiFetch,
    };
});

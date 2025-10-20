import { defineStore } from "pinia";
import { ref } from "vue";
import { useRouter } from "vue-router";

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
    const error = ref<string | null>(null);
    const router = useRouter();

    const login = async (email: string, password: string) => {
        loading.value = true;
        error.value = null;
        try {
            const response = await fetch('/api/login', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email, password }),
            });

            if (!response.ok) throw new Error('Invalid credentials');

            const data = await response.json();

            localStorage.setItem('auth_token', data.token);
            token.value = data.token;
            user.value = data.user;

            await router.push('/dashboard');
        } catch (err: any) {
            error.value = err.message;
        } finally {
            loading.value = false;
        }
    };

    const register = async (name: string, email: string, password: string, passwordConfirmation: string) => {
        loading.value = true;
        error.value = null;
        try {
            const response = await fetch('/api/register', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    name,
                    email,
                    password,
                    password_confirmation: passwordConfirmation
                }),
            });

            if (!response.ok) throw new Error('Registration failed');

            const data = await response.json();

            localStorage.setItem('auth_token', data.token);
            token.value = data.token;
            user.value = data.user;

            await router.push('/dashboard');
        } catch (err: any) {
            error.value = err.message;
        } finally {
            loading.value = false;
        }
    };

    const logout = async () => {
        if (token.value) {
            await fetch('/api/logout', {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token.value}`,
                    'Content-Type': 'application/json',
                },
            });
        }

        localStorage.removeItem('auth_token');
        token.value = null;
        user.value = null;
        await router.push('/login');
    };

    const apiFetch = async (url: string, options: RequestInit = {}) => {
        const headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            ...options.headers,
        };

        if (token.value) {
            (headers as any)['Authorization'] = `Bearer ${token.value}`;
        }

        return fetch(`/api${url}`, {
            ...options,
            headers,
        });
    };

    const fetchUser = async () => {
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

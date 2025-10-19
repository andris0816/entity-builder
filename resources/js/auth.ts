import {defineStore} from "pinia";
import {ref} from "vue";
import {useRouter} from "vue-router";

interface User {
    id: bigint;
    name: string;
    email: string;
    email_verified_at: string;
    created_at: string;
    updated_at: string;
}

const BASE_URL = "/api";
export const useAuthStore = defineStore('auth', () => {
   const user = ref<User | null>(null);
   const loading = ref(false);
   const error = ref<string | null>(null);
   const router = useRouter();

   const csrf = async (): Promise<void> => {
       await fetch(`/sanctum/csrf-cookie`, {
           method: "GET",
           credentials: "include",
       });
   }

    const fetchUser = async (): Promise<void> => {
        try {
            const response = await fetch(`${BASE_URL}/user`, {
                method: "GET",
                credentials: "include",
            });

            if (response.status === 401) {
                clearAuth();
                return;
            }

            if (response.status === 500) {
                throw new Error("Server issues, try again");
            }

            user.value = await response.json();
        } catch (err) {
            console.error("There was an error fetching user data", err);

            clearAuth();
        }
    }

    const login = async (email: string, password: string): Promise<void> => {
        loading.value = true;
        try {
            await csrf();

            const response = await fetch(`${BASE_URL}/login`, {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                credentials: "include",
                body: JSON.stringify({
                    email: email,
                    password: password,
                }),
            });

            if (!response.ok) throw new Error("Invalid credentials");

            const data = await response.json();
            user.value = data.user;

            await router.push('/dashboard');
        } catch (err: any) {
            error.value = err.message;
        } finally {
            loading.value = false;
        }
    };

    const register = async (name: string, email: string, password: string, passwordConfirmation: string): Promise<void> => {
        loading.value = true;
        try {
            await csrf();

            const response = await fetch(`${BASE_URL}/register`, {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                credentials: "include",
                body: JSON.stringify({
                    name: name,
                    email: email,
                    password: password,
                    password_confirmation: passwordConfirmation
                }),
            });

            if (!response.ok) throw new Error("Registration error");

            const data = await response.json();
            user.value = data.user;

            await router.push('/dashboard');
        } catch (err: any) {
            error.value = err.message;
        } finally {
            loading.value = false;
        }
    };

    const logout = async (): Promise<void> => {
        await fetch(`${BASE_URL}/logout`, {
            method: "POST",
            credentials: "include",
        });
        clearAuth();
    }

    const clearAuth = ()=> {
        user.value = null;
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
   };
});

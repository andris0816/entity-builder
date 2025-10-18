import {defineStore} from "pinia";
import {ref} from "vue";

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
   const token = ref(localStorage.getItem('auth_token'));

    const fetchUser = async (): Promise<void> => {
        try {
            const response = await fetch('api/user', {
                headers: {
                    'Authorization': `Bearer ${token.value}`,
                    'Accept': 'application/json'
                }
            });

            if (! response.ok) throw new Error('Failed to fetch user');

            user.value = await response.json();
        } catch (err) {
            clearAuth();
        }
    }

    const clearAuth = ()=> {
        user.value = null;
        token.value = null;
        localStorage.removeItem('auth_token');
    }

   return {
       user,
       token,
       fetchUser,
       clearAuth,
   };
});

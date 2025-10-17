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
   return { user };
});

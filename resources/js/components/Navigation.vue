<script setup lang="ts">
import {computed, ref} from "vue";
import { useAuthStore } from "../auth";

    interface Link {
        title: string;
        path: string;
        auth: 'user' | 'guest' | 'any';
    }

    const links = ref<Link[]>([
        {
            title: "My Worlds",
            path: "/dashboard",
            auth: 'user',
        },
        {
            title: "Sign in",
            path: "/login",
            auth: "guest",
        },
    ]);

    const authStore = useAuthStore();

    const filteredLinks = computed(() => {
        return links.value.filter(link => {
            if (link.auth === 'any') return true;
            if (link.auth === 'guest') return ! authStore.user;
            if (link.auth === 'user') return !! authStore.user;
        });
    });

    const handleLogout = async () => {
        try {
            await authStore.logout();
        } catch (err) {
            console.error("Logout failed:", err);
        }
    }
</script>

<template>
    <nav class="border-b border-gray-800 bg-gray-900/50 backdrop-blur-sm sticky top-0 z-50">
        <div class="mx-auto px-6 py-4 flex items-center justify-between">
            <RouterLink to="/">
                <div class="flex items-center gap-2 select-none">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="none" class="w-8 h-8">
                        <line x1="6" y1="22" x2="16" y2="6" stroke="white" stroke-width="2" stroke-linecap="round"/>
                        <line x1="6" y1="22" x2="26" y2="22" stroke="white" stroke-width="2" stroke-linecap="round"/>
                        <line x1="16" y1="6" x2="26" y2="22" stroke="white" stroke-width="2" stroke-linecap="round"/>
                        <circle cx="6" cy="22" r="5" fill="#22c55e"/> <!-- green -->
                        <circle cx="16" cy="6" r="5" fill="#3b82f6"/> <!-- blue -->
                        <circle cx="26" cy="22" r="5" fill="#f59e0b"/> <!-- amber -->
                    </svg>

                    <span class="text-xl font-semibold bg-gradient-to-r from-blue-400 via-purple-400 to-pink-400 bg-clip-text text-transparent">
                    entity
                </span>
                    <span class="text-white/50 font-light tracking-wide">builder</span>
                </div>
            </RouterLink>

            <div class="flex items-center gap-6">
                <RouterLink v-for="link in filteredLinks" :key="link.path" :to="link.path">
                    {{ link.title }}
                </RouterLink>
            </div>
            <button
                v-if="authStore.user"
                @click="handleLogout"
                class="cursor-pointer"
            >
                Logout
            </button>
        </div>
    </nav>
</template>

<style scoped>

</style>

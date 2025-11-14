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

    const menuOpen = ref(false);

    const toggleMenu = () => {
        menuOpen.value = !menuOpen.value;
    }

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
    <nav class="border-b border-gray-800 bg-gray-900/50 backdrop-blur-sm sticky top-0 z-50" role="navigation" aria-label="Main navigation">
        <div class="mx-auto px-6 py-4 flex items-center justify-between">
            <RouterLink to="/" aria-label="Entity Builder Home">
                <div class="flex items-center gap-2 select-none">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 32 32"
                        fill="none"
                        class="w-8 h-8"
                        aria-hidden="true"
                    >
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
            <button
                class="md:hidden p-2 rounded focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500"
                type="button"
                @click="toggleMenu"
                aria-controls="nav-links"
                aria-label="Toggle navigation"
            >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                aria-hidden="true"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16"
                />
            </svg>
            </button>
            <div
                id="nav-links"
                :class="[
                  menuOpen ? 'flex flex-col mt-4 gap-4' : 'hidden',
                  'md:flex md:flex-row md:gap-6 md:ml-auto md:mt-0'
                ]"
            >
                <RouterLink
                    v-for="link in filteredLinks"
                    :key="link.path"
                    :to="link.path"
                    :aria-current="$route.path === link.path ? 'page' : null"
                    class="block"
                >
                    {{ link.title }}
                </RouterLink>

                <button
                    v-if="authStore.user"
                    @click="handleLogout"
                    type="button"
                    aria-label="Log out"
                    class="block md:ml-6"
                >
                    Logout
                </button>
            </div>
        </div>
    </nav>
</template>

<style scoped>

</style>

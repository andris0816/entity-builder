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
            title: "Dashboard",
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

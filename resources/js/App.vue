<template>
    <main class="text-gray-50">
        <div class="size-full dark">
            <div class="min-h-screen bg-gray-950">
                <Navigation />
                <RouterView />
            </div>
        </div>
    </main>
</template>
<script setup lang="ts">
    import Navigation from "./components/Navigation.vue";
    import {useAuthStore} from "./auth";
    import {onMounted} from "vue";


    const authStore = useAuthStore();

    onMounted(async () => {
        const token = localStorage.getItem('token');

        if (token) {
            try {
                await authStore.fetchUser();
            } catch (err) {
                console.error("Something went wrong while fetching user", err);
                authStore.clearAuth();
            }
        }
    });
</script>

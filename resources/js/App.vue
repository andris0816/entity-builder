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
        await authStore.fetchUser();
    });
</script>

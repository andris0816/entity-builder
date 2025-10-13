<script setup>
    import {ref} from "vue";

    const links = ref([
        { title: "Profile", path: "/profile"},
        { title: "Sign in", path: "/register"},
    ]);
</script>

<template>
    <nav class="border-b border-gray-800 bg-gray-900/50 backdrop-blur-sm sticky top-0 z-50">
        <div class="mx-auto px-6 py-4 flex items-center justify-between">
            <RouterLink v-for="link in links" :key="link.path" :to="link.path"
            >
                {{ link.title }}
            </RouterLink>
        </div>
    </nav>
</template>

<style scoped>

</style>

<template>
    <h1>Hello App!</h1>
    <p><strong>Current route path:</strong> {{ $route.fullPath }}</p>
    <nav>
        <RouterLink to="/">Go to Home</RouterLink>
    </nav>
    <main class="container text-gray-50">
        <RouterView />
    </main>
</template>
<script setup lang="ts">
</script>

<script setup>

</script>

<template>
    <div class="bg-gray-900 border border-gray-800 hover:border-gray-700 px-6 rounded-lg shadow-none py-4">
        <h3 class="text-white mb-2">
            <slot name="title"></slot>
        </h3>
        <p class="text-gray-400 text-sm">
            <slot name="desc"></slot>
        </p>
    </div>
</template>

<style scoped>

</style>

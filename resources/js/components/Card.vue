<script setup>
    defineProps({
        customClass: { type: String, default: '' }
    });
</script>

<template>
    <div :class="['bg-gray-900 border border-gray-800 rounded-xl p-6', customClass]">
        <slot />
    </div>
</template>

<style scoped>

</style>

<script setup>
    defineProps({
        text: String,
        customClass: {type: String, default: ''},
    });
</script>

<template>
    <button :class="['px-3 py-2 border rounded-lg text-lg font-medium', customClass]">{{ text }}</button>
</template>

<style scoped>

</style>

<script setup lang="ts">
    interface Props {
        text?: string;
        customClass?: string
    }

    const props = withDefaults(defineProps<Props>(), {
        customClass: '',
        text: ''
    });
</script>

<template>
    <button :class="['px-3 py-2 border rounded-lg text-lg font-medium', props.customClass]">{{ props.text }}</button>
</template>

<style scoped>

</style>

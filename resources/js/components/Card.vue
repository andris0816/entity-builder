<script setup lang="ts">

    interface Props {
        customClass?: string;
    }

    const props = withDefaults(defineProps<Props>(), {
        customClass: ''
    });
</script>

<template>
    <div :class="['bg-gray-900 border border-gray-800 rounded-xl p-6', props.customClass]">
        <slot />
    </div>
</template>

<style scoped>

</style>

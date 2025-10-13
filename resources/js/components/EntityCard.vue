<script setup lang="ts">
    import {computed, defineProps} from "vue";

    interface Props {
        entity: Entity;
    }

    const props = defineProps<Props>();

    const gradientClasses = computed(() => `bg-gradient-to-br ${props.entity.gradient}`);
</script>

<template>
    <div class="group">
        <div :class="['rounded-2xl p-6 shadow-2xl transition-all hover:scale-105', gradientClasses]">
            <div class="w-12 h-12 rounded-full bg-white/50 mx-auto"></div>
            <p class="text-sm text-center mt-2">{{ props.entity.title }}</p>
            <p class="text-xs text-center">{{ props.entity.subtitle }}</p>
        </div>
    </div>
</template>

<style scoped>

</style>

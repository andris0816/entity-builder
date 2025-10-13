<script setup>
    import {computed, defineProps} from "vue";

    const { entity } = defineProps({
        entity: { type: Object, required: true }
    })

    const gradientClasses = computed(() => `bg-gradient-to-br ${entity.gradient}`)
</script>

<template>
    <div class="group">
        <div :class="['rounded-2xl p-6 shadow-2xl transition-all hover:scale-105', gradientClasses]">
            <div class="w-12 h-12 rounded-full bg-white/50 mx-auto"></div>
            <p class="text-sm text-center mt-2">{{ entity.title }}</p>
            <p class="text-xs text-center">{{ entity.subtitle }}</p>
        </div>
    </div>
</template>

<style scoped>

</style>

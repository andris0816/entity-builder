<script setup lang="ts">
import {entityColorClasses} from "../data/entityColor";
import {computed} from "vue";

const props = defineProps<{
    type: string;
}>();

const colorClass = computed(() => entityColorClasses[props.type] || "gray-500");
</script>

<template>
    <span
        :class="[
                `inline-flex items-center justify-center rounder-md
                    border px-2 py-0.5 text-xs font-medium w-fit
                    whitespace-nowrap shrink-0 [&>svg]:size-3 gap-1 [&>svg]:pointer-events-none`,
                `bg-${colorClass}/20`,
                `text-${colorClass}/50`,
                `border-${colorClass}`,
        ]"
    >
        {{ type }}
    </span>
</template>

<style scoped>

</style>

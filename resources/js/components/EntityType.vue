<script setup lang="ts">
import {defaultColorClasses, entityColorClasses} from "../data/entityColor";
import {computed} from "vue";

const props = defineProps<{
    type: string;
}>();

const colorClasses = computed(() => entityColorClasses[props.type] || defaultColorClasses);
</script>

<template>
    <span
        :class="[
            'inline-flex items-center justify-center rounded-md transition-[color,box-shadow] border px-2 py-0.5 text-xs font-medium w-fit whitespace-nowrap shrink-0 [&>svg]:size-3 gap-1 [&>svg]:pointer-events-none',
            colorClasses.bg,
            colorClasses.text,
            colorClasses.border
        ]"
    >
        {{ type }}
    </span>
</template>

<style scoped>

</style>

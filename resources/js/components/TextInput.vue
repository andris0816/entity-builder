<script setup lang="ts">
    interface Props {
        paceHolder?: string;
        modelValue: string;
        customClass?: string;
    }

    const props = defineProps<Props>();
    const emit = defineEmits<{
        'update:modelValue': [value: string]
    }>();
</script>

<template>
    <input
        :value="modelValue"
        :class="
        [
            'selection:bg-primary',
            'selection:text-primary-foreground',
            'flex',
            'h-9',
            'w-full',
            'min-w-0',
            'rounded-md',
            'border',
            'px-3',
            'py-1',
            'text-base',
            'transition-[color,box-shadow]',
            'outline-none',
            'disabled:pointer-events-none',
            'disabled:cursor-not-allowed',
            'disabled:opacity-50',
            'md:text-sm',
            'focus-visible:border-ring',
            'focus-visible:ring-ring/50',
            'focus-visible:ring-[3px]'
            customClass
        ]"
    />
</template>

<style scoped>

</style>

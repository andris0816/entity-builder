<script setup lang="ts">
import {computed} from "vue";

interface Props {
    modelValue: string;
    customClass?: string;
    label?: string;
    error?: string;
    disabled?: boolean;
    placeholder?: string;
}

const props = withDefaults(defineProps<Props>(), {
    type: 'text',
    disabled: false,
    customClass: ''
});

const emit = defineEmits<{
    'update:modelValue': [value: string]
}>();

const value = computed({
    get: () => props.modelValue,
    set: (value: string) => emit('update:modelValue', value)
})

const baseInputClasses = [
    'selection:bg-primary',
    'selection:text-primary-foreground',
    'flex',
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
    'focus-visible:border-gray-500',
    'focus-visible:ring-gray-500/40',
    'focus-visible:ring-[3px]',
    'aria-invalid:ring-destructive',
    'aria-invalid:border-destructive',
    'bg-gray-950/80',
    'border-gray-700',
    'text-white',
    'placeholder:text-gray-500',
    'mt-1'
];

const inputClasses = computed(() => [...baseInputClasses, props.customClass]);
</script>

<template>
    <label v-if="label" class="block space-y-2">
        <span class="text-sm font-medium text-gray-300">{{ label }}</span>
        <textarea
            v-model="value"
            :placeholder="placeholder"
            :disabled="disabled"
            :aria-invalid="!! error"
            v-bind="$attrs"
            :class="inputClasses"
        />
    </label>
    <textarea
        v-else
        v-model="value"
        :placeholder="placeholder"
        :disabled="disabled"
        :aria-invalid="!! error"
        v-bind="$attrs"
        :class="inputClasses"
    />

    <div v-if="error" class="text-sm text-red-500">{{ error }}</div>
</template>

<style scoped>

</style>
textarea

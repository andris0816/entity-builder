<script setup lang="ts">
    import {computed} from "vue";
    interface Props {
        type?: 'button' | 'submit' | 'reset';
        disabled: boolean
        customClass?: string
        variant?: 'default' | 'gradient' | 'dark'
    }

    const props = withDefaults(defineProps<Props>(), {
        customClass: '',
        disabled: false,
        variant: "default"
    });

    const variantClasses = {
        'default': [
            'text-black',
            'bg-white',
        ],
        'gradient': [
            'bg-gradient-to-r',
            'from-blue-500',
            'to-purple-400',
            'hover:from-blue-600',
            'hover:to-purple-700',
            'shadow-2xl',
            'shadow-blue-500/50',
            'text-black'
        ],
        'dark': [
            'border-gray-600',
            'g-gray-800/50',
            'hover:bg-gray-800'
        ]
    };

    const baseClasses = [
        'px-3',
        'py-2',
        'border',
        'rounded-lg',
        'text-lg',
        'font-medium'
    ];

    const buttonClasses = computed(() => [
        ...baseClasses,
        ...variantClasses[props.variant],
        props.customClass]);
</script>

<template>
    <button
        :class="buttonClasses"
        :type="type"
        :disabled="disabled"
        v-bind="$attrs"
    >
        <slot />
    </button>
</template>

<style scoped>

</style>

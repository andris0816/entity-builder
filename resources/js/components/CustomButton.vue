<script setup lang="ts">
    import {computed} from "vue";
    import {getButtonClasses} from "../data/button-classes";

    interface Props {
        type?: 'button' | 'submit' | 'reset';
        disabled?: boolean
        customClass?: string
        variant?: 'default' | 'gradient' | 'dark' | 'danger'
    }

    const props = withDefaults(defineProps<Props>(), {
        customClass: '',
        disabled: false,
        variant: "default"
    });

    const buttonClasses = computed(() =>
       getButtonClasses(props.variant, props.customClass)
    );
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

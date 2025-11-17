<script setup lang="ts">
    import {getButtonClasses} from "../data/button-classes";
    import {computed} from "vue";

    interface Props {
        href: string;
        customClass?: string
        variant?: 'default' | 'gradient' | 'dark'
    }

    const props = withDefaults(defineProps<Props>(), {
       customClass: '',
       variant: 'default'
    });

    const buttonClasses = computed(() =>
        getButtonClasses(props.variant, props.customClass)
    );
</script>

<template>
    <RouterLink
        :to="href"
        :class="buttonClasses"
    >
    <slot />
    </RouterLink>
</template>

<style scoped>

</style>

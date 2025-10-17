<script setup lang="ts">
import Button from "./Button.vue";
import Card from "./Card.vue";

interface Props {
    show: boolean;
}

const props = withDefaults(defineProps<Props>(), {
   show: false,
});

</script>

<template>
    <Transition
        enter-from="opacity-0"
        enter-to-class="opacity-100"
        enter-active-class="transition duration-300"
        leave-active-class="transition duration-200"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
    >
        <div
            v-if="show"
            class="fixed inset-0 bg-black/[.6] grid place-items-center"
        >
            <Card customClass="w-9/12 max-w-lg " @click.stop>
                <header class="text-xl mb-4">
                    <slot name="header">
                        <h2>Default Header</h2>
                    </slot>
                </header>

                <main>
                    <slot></slot>
                </main>

                <footer class="pt-2 mt-2">
                    <slot name="footer">
                        <Button
                            @click="$emit('close')"
                            variant="dark"
                        >
                            Cancel
                        </Button>
                    </slot>
                </footer>
            </Card>
        </div>
    </Transition>
</template>

<style scoped>

</style>

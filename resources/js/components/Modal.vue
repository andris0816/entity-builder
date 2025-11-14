<script setup lang="ts">
import CustomButton from "./CustomButton.vue";
import Card from "./Card.vue";
import {onBeforeUnmount, onMounted} from "vue";

interface Props {
    show: boolean;
}

const props = withDefaults(defineProps<Props>(), {
   show: false,
});

const emit = defineEmits(["close"]);

const handleEscape = (e: any) => {
    if (e.key === "Escape") {
        emit("close");
    }
}

onMounted(() => {
    window.addEventListener("keydown", handleEscape);
});

onBeforeUnmount(() => {
    window.addEventListener("keydown", handleEscape);
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
            role="dialog"
            aria-modal="true"
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
                        <CustomButton
                            @click="$emit('close')"
                            variant="dark"
                        >
                            Cancel
                        </CustomButton>
                    </slot>
                </footer>
            </Card>
        </div>
    </Transition>
</template>

<style scoped>

</style>

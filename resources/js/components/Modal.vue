<script setup lang="ts">
interface Props {
    show: boolean;
}

const props = withDefaults(defineProps<Props>(), {
   show: false,
});

</script>

<template>
    <div
        v-if="show"
        class="fixed inset-0 bg-black/[.6] grid place-items-center"
    >
        <div class="bg-gray-900 border-gray-800 p-4 rounded w-9/12 max-w-lg" @click.stop>
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
                    <button
                        @click="$emit('close')"
                        class="py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                    >
                        Close
                    </button>
                </slot>
            </footer>
        </div>
    </div>
</template>

<style scoped>

</style>

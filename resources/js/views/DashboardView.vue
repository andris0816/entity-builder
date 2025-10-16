<script setup lang="ts">

import Button from "../components/Button.vue";
import WorldCard from "../components/WorldCard.vue";
</script>

<template>
    <div class="max-w-7xl mx-auto px-6 py-12">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-white mb-2">Your Worlds</h2>
                <p class="text-gray-400">Select a world to explore or create a new one</p>
            </div>
            <div>
                <Button variant="gradient" customClass="text-sm inline-flex items-center justify-center gap-2">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="lucide lucide-plus w-4 h-4 mr-2"
                        aria-hidden="true"
                    >
                        <path d="M5 12h14"></path>
                        <path d="M12 5v14"></path>
                    </svg>
                    New World
                </Button>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <WorldCard></WorldCard>
            <WorldCard></WorldCard>
            <WorldCard></WorldCard>
            <WorldCard></WorldCard>
            <WorldCard></WorldCard>
            <WorldCard></WorldCard>
        </div>
    </div>
</template>

<style scoped>

</style>

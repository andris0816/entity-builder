<script setup lang="ts">

import Card from "./Card.vue";
import EntityCard from "./EntityCard.vue";
import Button from "./Button.vue";
import type { Entity } from "../data/entityData.ts"

interface Props {
    entities: Entity[];
}

const props = defineProps<Props>();

</script>

<template>
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-600/20 via-purple-600/20 to-pink-600/20 blur-3xl"></div>
        <div class="relative max-w-7xl mx-auto px-6 py-24 md:py-32">
            <div class="text-center max-w-4xl mx-auto">
                <div class="inline-flex justify-center items-center gap-2 my-10 py-2 px-4 border border-gray-700 bg-gray-800/50 rounded-4xl">
                    <svg class="lucide lucide-sparkles w-4 h-4 text-purple-400"
                         xmlns="http://www.w3.org/2000/svg"
                         width="24"
                         height="24"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2"
                         stroke-linecap="round"
                         stroke-linejoin="round"
                         aria-hidden="true"
                    >
                        <path d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z"></path>
                        <path d="M20 2v4"></path>
                        <path d="M22 4h-4"></path>
                        <circle cx="4" cy="20" r="2"></circle>
                    </svg>
                    <span class="ml-auto">Worldbuilding Made Visual</span>
                </div>
                <h1 class="text-white mb-6 text-5xl md:text-6xl lg:text-7xl">Map Your
                    <span class="bg-gradient-to-r from-blue-400 via-purple-400 to-pink-400 bg-clip-text text-transparent">Fictional Worlds</span>
                </h1>
                <p class="text-xl max-w-2xl mx-auto opacity-65">
                    The ultimate tool for writers, game designers, and creators to visualize and organize complex story universes with beautiful interactive graphs.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-3 py-8 mb-16">
                    <Button
                        customClass="
                            bg-gradient-to-r
                            from-blue-500
                            to-purple-400
                            hover:from-blue-600
                            hover:to-purple-700
                            shadow-2xl
                            shadow-blue-500/50
                            text-black"

                        text="Get Started Free"
                    />
                    <Button customClass="border-gray-600 g-gray-800/50 hover:bg-gray-800" text="Sign In" />
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <EntityCard v-for="entity in props.entities" :entity="entity" />
                </div>
                <div>
                    <Card customClass="mt-6">
                        <div class="flex justify-between items-center">
                            <div class="h-16 w-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl p-6 flex items-center justify-center">
                                <span class="text-white text-xs">Aria</span>
                            </div>
                            <div class="flex-1 border-t-2 border-dashed border-gray-600 relative">
                                <span class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-gray-900 px-2 text-xs text-gray-400">owns</span>
                            </div>
                            <div class="h-16 w-16 bg-gradient-to-br from-orange-400 to-orange-600 rounded-2xl p-6 flex items-center justify-center">
                                <span class="text-white text-xs">Sword</span>
                            </div>
                            <div class="flex-1 border-t-2 border-dashed border-gray-600 relative">
                                <span class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-gray-900 px-2 text-xs text-gray-400">used in</span>
                            </div>
                            <div class="h-16 w-16 bg-gradient-to-br from-purple-400 to-purple-600 rounded-2xl p-6 flex items-center justify-center">
                                <span class="text-white text-xs">Battle</span>
                            </div>
                        </div>
                        <p class="mt-8 card-desc">Connect entities with meaningful relationships to build your story</p>
                    </Card>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>

</style>

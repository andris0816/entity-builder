<script setup lang="ts">
    import Card from "../Card.vue";
    import {getRandomGradient} from "../../utils/gradient";
    import {World} from "../../types/world";
    import {timeAgo} from "../../utils/timeAgo";
    import EditButton from "../WorldMap/EditButton.vue";
    import DeleteButton from "../WorldMap/DeleteButton.vue";

    interface Props {
        world: World;
        customClass?: string;
    }

    const props = withDefaults(defineProps<Props>(), {
        customClass: '',
    });

    const emit = defineEmits<{
        (e: 'edit', world: World): void,
        (e: 'delete', world: World): void
    }>();

    const { world, customClass } = props;
    const gradientClass = getRandomGradient();
</script>

<template>
    <div
        class="w-full h-full"
        role="button"
    >
        <Card customClass="relative group w-full h-full hover:border-gray-700 transition-all cursor-pointer group flex flex-col gap-6">
            <div
                class="absolute top-3 right-3 flex gap-2 opacity-0 group-hover:opacity-100
                     bg-gray-800/80 backdrop-blur-sm p-2 rounded-lg shadow-md shadow-black/30
                     transition-opacity z-10"
            >
                <EditButton @click.stop="$emit('edit', world)" />
                <DeleteButton @click.stop="$emit('delete', world)" />
            </div>

            <div :class="`w-full h-32 ${gradientClass} rounded-lg mb-4 flex items-center justify-center group-hover:scale-105 transition-transform`">
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
                    class="lucide lucide-book w-12 h-12 text-white opacity-80"
                    aria-hidden="true"
                >
                    <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20"></path>
                </svg>
            </div>
            <div class="flex flex-col">
                <h4 class="text-white mb-1">{{ world.name }}</h4>
                <p class="text-gray-400">{{ world.desc }}</p>
            </div>
            <div class="mt-auto">
                <div class="flex items-center gap-4 text-sm text-gray-400">
                    <div class="flex items-center gap-1">
                        <span>
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
                                class="lucide lucide-map-pin w-4 h-4"
                                aria-hidden="true"
                            >
                                <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                        </span>
                        <span>
                            {{ world.entitiesCount }}
                        </span>
                    </div>
                    <div class="flex items-center gap-1">
                        <span>
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
                                class="lucide lucide-calendar w-4 h-4"
                                aria-hidden="true"
                            >
                                <path d="M8 2v4"></path>
                                <path d="M16 2v4"></path>
                                <rect width="18" height="18" x="3" y="4" rx="2"></rect>
                                <path d="M3 10h18"></path>
                            </svg>
                        </span>
                        <span>
                            {{ timeAgo(world.createdAt) }}
                        </span>
                    </div>
                </div>
            </div>
        </Card>
    </div>
</template>

<style scoped>

</style>

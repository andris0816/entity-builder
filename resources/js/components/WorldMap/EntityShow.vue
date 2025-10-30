<script setup lang="ts">
import {useWorldStore} from "../../stores/world";
import EntityType from "../EntityType.vue";
import RelatedEntities from "../RelatedEntities.vue";
import {computed} from "vue";
import {Relationship} from "../../types/relationship";
import {Entity} from "../../types/entity";

const worldStore = useWorldStore();

const selectedEntity = computed(() => worldStore.selectedEntity);
const relatedEntities = computed<
    { relationship: Relationship; entity?: Entity }[]
>(() => {
    if (!selectedEntity.value) return [];

    return worldStore.relatedEntities(selectedEntity.value.id);
});
</script>

<template>
    <div v-if="!selectedEntity" class="flex items-center justify-center h-full text-center text-gray-500">
        <p>Select an entity to view details</p>
    </div>
    <div v-else>
        <div class="space-y-3">
            <div class="flex items-start justify-between">
                <h3>{{ selectedEntity.name }}</h3>
            </div>
            <div class="flex gap-1">
                <button>
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
                        class="lucide lucide-pen w-4 h-4"
                        aria-hidden="true"
                    >
                        <path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"></path>
                    </svg>
                </button>
                <button>
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
                        class="lucide lucide-trash2 lucide-trash-2 w-4 h-4"
                        aria-hidden="true"
                    >
                        <path d="M10 11v6"></path>
                        <path d="M14 11v6"></path>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"></path>
                        <path d="M3 6h18"></path>
                        <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    </svg>
                </button>
            </div>
        </div>
        <EntityType :type="selectedEntity.type" />
        <div class="space-y-3">
            <h4 class="text-gray-400">Description</h4>
            <p class="card-desc">{{ selectedEntity.desc }}</p>
        </div>
        <div class="space-y-3">
            <h4 class="text-gray-400">Related Entities</h4>
            <RelatedEntities
                v-for="item in relatedEntities"
                :key="item.relationship.id"
                :entity="item.entity"
                :relationship="item.relationship"
            />
        </div>
    </div>
</template>

<style scoped>

</style>

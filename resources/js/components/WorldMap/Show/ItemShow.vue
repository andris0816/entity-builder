<script setup lang="ts">
import {useWorldStore} from "../../../stores/world";
import {computed} from "vue";
import EntityShow from "./EntityShow.vue";
import RelationshipShow from "./RelationshipShow.vue";


const worldStore = useWorldStore();

const selectedItem = computed(() => worldStore.selectedItem);
</script>

<template>
    <div v-if="!selectedItem" class="flex items-center justify-center h-full text-center text-gray-500">
        <p>Select an entity to view details</p>
    </div>
    <div v-else class="space-y-6">
        <EntityShow v-if="selectedItem.type === 'entity'" />
        <RelationshipShow v-if="selectedItem?.type === 'relationship'" />
    </div>
</template>

<style scoped>

</style>

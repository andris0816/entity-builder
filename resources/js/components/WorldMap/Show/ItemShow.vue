<script setup lang="ts">
import {useWorldStore} from "../../../stores/world";
import {computed} from "vue";
import Entity from "./Entity.vue";
import Relationship from "./Relationship.vue";


const worldStore = useWorldStore();

const selectedItem = computed(() => worldStore.selectedItem);
</script>

<template>
    <div v-if="!selectedItem" class="flex items-center justify-center h-full text-center text-gray-500">
        <p>Select an entity to view details</p>
    </div>
    <!-- Két opció: vagy relationship vagy entity -> mindkettő külön component    -->
    <div class="space-y-6">
        <Entity v-if="selectedItem?.type === 'entity'" />
        <Relationship v-if="selectedItem?.type === 'relationship'" />
    </div>
</template>

<style scoped>

</style>

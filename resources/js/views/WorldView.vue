<script setup lang="ts">
import EntityCreate from "../components/WorldMap/EntityCreate.vue";
import {computed, onMounted, ref} from "vue";
import {apiFetch} from "../utils/api";
import {useRoute} from "vue-router";
import Map from "../components/WorldMap/Map.vue";
import RelationshipCreate from "../components/WorldMap/RelationshipCreate.vue";
import {Entity} from "../types/entity";
import {Relationship} from "../types/relationship";

const route = useRoute();
const entities = ref<Entity[]>([]);
const relationships = ref<Relationship[]>([]);

onMounted(async() => {
   const response = await apiFetch(`/worlds/${route.params.id}`);

   if (response.status === 404) {
       return;
   }

   const data = await response.json();

   entities.value = data.data.entities;
   relationships.value = data.data.relationships
});

const saveEntity = async (formData: any) => {
    try {
        formData.world_id = route.params.id;
        const response = await apiFetch('/entity', {
            method: "POST",
            body: JSON.stringify(formData)
        });

        if (!response.ok) throw new Error('Failed to save entity');

        const data = await response.json();

        console.log(data);
    } catch (err) {
        console.error(err);
    }
}

const saveRelationship = async (formData: any) => {
    try {
        formData.world_id = route.params.id;
        const response = await apiFetch('/relationship', {
            method: "POST",
            body: JSON.stringify(formData)
        });

        if (!response.ok) throw new Error('Failed to save relationsip');

        const data = await response.json();

        console.log(data);
    } catch (err) {
        console.error(err);
    }
}

const simplifiedEntities = computed(() => {
    return entities.value.map(({ id, name }) => ({ id, name }))
});

</script>

<template>
    <div class="flex-1 flex overflow-hidden">
        <div class="w-[280px] bg-gray-900 border-r border-gray-800 h-full overflow-y-auto p-6 space-y-8">
            <div class="space-y-4">
                <EntityCreate @submit="saveEntity"></EntityCreate>
            </div>
            <div class="space-y-4">
                <RelationshipCreate @submit="saveRelationship" :entities="simplifiedEntities"></RelationshipCreate>
            </div>
        </div>
        <div class="flex-1 bg-gray-950 h-full relative">
            <Map></Map>
        </div>
    </div>
</template>

<style scoped>

</style>

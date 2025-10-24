<script setup lang="ts">
import EntityCreate from "../components/WorldMap/EntityCreate.vue";
import {onMounted} from "vue";
import {apiFetch} from "../utils/api";
import {useRoute} from "vue-router";
import Map from "../components/WorldMap/Map.vue";

const route = useRoute();

onMounted(async() => {
   const response = await apiFetch(`/worlds/${route.params.id}`);

   if (response.status === 404) {
       return;
   }

   const data = await response.json();
});

const saveEntity = async (formData: any) => {
    try {
        formData.world_id = route.params.id;
        const response = await apiFetch('/entity', {
            method: "POST",
            body: JSON.stringify(formData)
        });

        if (!response.ok) throw new Error('Failed to save item');

        const data = await response.json();

        console.log(data);
    } catch (err) {
        console.error(err);
    }
}
</script>

<template>
    <div class="flex-1 flex overflow-hidden">
        <div class="w-[280px] bg-gray-900 border-r border-gray-800 h-full overflow-y-auto p-6 space-y-8">
            <div class="space-y-4">
                <EntityCreate @submit="saveEntity"></EntityCreate>
            </div>
        </div>
        <div class="flex-1 bg-gray-950 h-full relative">
            <Map></Map>
        </div>
    </div>
</template>

<style scoped>

</style>

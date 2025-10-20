<script setup lang="ts">

import WorldCard from "../components/Dashboard/WorldCard.vue";
import DashboardHeader from "../components/Dashboard/DashboardHeader.vue";
import {onMounted, ref} from "vue";
import {World} from "../types/world";
import {apiFetch} from "../utils/api";


// const authStore = useAuthStore();
const worlds = ref<World[]>([]);


onMounted(async () => {
    try {
        const response = await apiFetch('/world', {
            method: "GET",
        });

        const data = await response.json();
        worlds.value = data.worlds;
    } catch (err) {
        console.error("There was an error while loading in worlds", err);
    }
});

function onWorldSaved(newWorld: World) {
    worlds.value.push(newWorld);
}
</script>

<template>
    <div class="max-w-7xl mx-auto px-6 py-12">
        <DashboardHeader @saved="onWorldSaved" />
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <WorldCard v-for="world in worlds" :world="world" :key="world.id"></WorldCard>
        </div>
    </div>
</template>

<style scoped>

</style>

<script setup lang="ts">

import WorldCard from "../components/Dashboard/WorldCard.vue";
import DashboardHeader from "../components/Dashboard/DashboardHeader.vue";
import {onMounted, ref} from "vue";
import {World} from "../types/world";
import {apiFetch} from "../utils/api";
import {useRouter} from "vue-router";
import WorldEditModal from "../components/Dashboard/WorldEditModal.vue";
import WorldDeleteModal from "../components/Dashboard/WorldDeleteModal.vue";
import {toast} from "../utils/toast";

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

const router = useRouter();

const selectedWorld = ref(null);
const editModalOpen = ref(false);
const deleteModalOpen = ref(false);

function openEditModal(world: World) {
    selectedWorld.value = world;
    editModalOpen.value = true;
}

function openDeleteModal(world: World) {
    selectedWorld.value = world;
    deleteModalOpen.value = true;
}

const onWorldSaved = (newWorld: World) => {
    worlds.value.push(newWorld);
}

const onWorldUpdated = (updatedWorld: Partial<World>) => {
    const world = worlds.value.find(w => w.id === selectedWorld.value.id);
    if (world) Object.assign(world, updatedWorld);
    selectedWorld.value = null as World;
}

const onWorldDeleted = (deletedWorldId: number) => {
    const index = worlds.value.findIndex(w => w.id === deletedWorldId);
    if (index !== -1) worlds.value.splice(index, 1);
}

const handleClickedWorld = (clickedWorld: World) => {
    router.push({name: 'world.show', params: { id: clickedWorld.id }})
}
</script>

<template>
    <div class="max-w-7xl mx-auto px-6 py-12">
        <DashboardHeader @saved="onWorldSaved" />
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <WorldCard
                v-for="world in worlds"
                :world="world"
                :key="world.id"
                @click="handleClickedWorld(world)"
                @edit="openEditModal"
                @delete="openDeleteModal"
            />
        </div>
    </div>

    <WorldEditModal
        v-if="editModalOpen"
        :world="selectedWorld"
        @updated="onWorldUpdated"
        @close="editModalOpen = false"
    />

    <WorldDeleteModal
        v-if="deleteModalOpen"
        :world="selectedWorld"
        @deleted="onWorldDeleted"
        @close="deleteModalOpen = false"
    />
</template>

<style scoped>

</style>

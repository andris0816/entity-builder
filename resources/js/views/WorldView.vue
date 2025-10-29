<script setup lang="ts">
import EntityCreate from "../components/WorldMap/EntityCreate.vue";
import {computed, onMounted, ref} from "vue";
import {apiFetch} from "../utils/api";
import {useRoute} from "vue-router";
import Map from "../components/WorldMap/Map.vue";
import RelationshipCreate from "../components/WorldMap/RelationshipCreate.vue";
import {ValidationErrors} from "../types/ValidationErrors";
import {useWorldStore} from "../stores/world";
import EntityShow from "../components/WorldMap/EntityShow.vue";

const route = useRoute();
const errors = ref<ValidationErrors>({});
const worldStore = useWorldStore();

onMounted(async() => {
   await worldStore.loadWorld(route.params.id);
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

        worldStore.addEntity(data);
    } catch (err) {
        console.error(err);
    }
}

const saveRelationship = async (formData: any) => {
    errors.value = {};

    try {
        formData.world_id = route.params.id;
        const response = await apiFetch('/relationship', {
            method: "POST",
            body: JSON.stringify(formData)
        });

        const data = await response.json();

        if (!response.ok) {
            if (response.status === 422) {
                errors.value = data.errors || {};
            } else {
                console.error('Server error:', data.message || data);
            }
            return;
        }

        worldStore.addRelationship(data);
        errors.value = {};
    } catch (err) {
        console.error(err);
    }
}
</script>

<template>
    <div class="flex-1 flex overflow-hidden">
        <div class="w-[280px] bg-gray-900 border-r border-gray-800 h-full overflow-y-auto p-6 space-y-8">
            <div class="space-y-4">
                <EntityCreate
                    @submit="saveEntity"
                    :errors="errors"
                />
            </div>
            <div class="space-y-4">
                <RelationshipCreate
                    @submit="saveRelationship"
                    :entities="worldStore.simplifiedEntities"
                    :errors="errors"
                />
            </div>
        </div>
        <div class="flex-1 bg-gray-950 h-full relative">
            <Map></Map>
        </div>
        <div class="w-[280px] bg-gray-900 border-l border-gray-800 h-auto overflow-y-auto p-6 space-y-6">
            <EntityShow />
        </div>
    </div>
</template>

<style scoped>

</style>

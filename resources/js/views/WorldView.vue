<script setup lang="ts">
import EntityCreate from "../components/WorldMap/EntityCreate.vue";
import {onMounted} from "vue";
import {apiFetch} from "../utils/api";
import {useRoute} from "vue-router";

const route = useRoute()

onMounted(async() => {
   const response = await apiFetch(`/worlds/${route.params.id}`);

   const data = await response.json();
});
</script>

<template>
    <div class="w-[280px] bg-gray-900 border-r border-gray-800 h-full overflow-y-auto p-6 space-y-8">
        <div class="space-y-4">
            <EntityCreate></EntityCreate>
        </div>
    </div>
</template>

<style scoped>

</style>

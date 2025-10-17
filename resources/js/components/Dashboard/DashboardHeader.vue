<script setup lang="ts">

import WorldStoreModal from "./WorldStoreModal.vue";
import {World} from "../../types/world";


const emit = defineEmits<{
    (e: 'saved', world: World);
}>();

function handleWorldSaved(world: World) {
    emit('saved', world);
}
</script>

<template>
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-white mb-2">Your Worlds</h2>
            <p class="text-gray-400">Select a world to explore or create a new one</p>
        </div>
        <div>
            <WorldStoreModal @saved="handleWorldSaved"/>
        </div>
    </div>
</template>

<style scoped>

</style>

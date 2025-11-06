<script setup lang="ts">
import {Entity} from "../types/entity";
import {Relationship} from "../types/relationship";
import EntityType from "./EntityType.vue";

interface Props {
    entity: Entity;
    relationship?: Relationship
}

const props = defineProps<Props>();
</script>

<template>
<div class="p-3 rounded-lg bg-gray-800/50 border border-gray-700 space-y-1">
    <div class="flex items-center justify-between">
    <span class="text-sm text-gray-200">
        {{ entity.name }}
    </span>
        <EntityType :type="entity.type" />
    </div>
    <p v-if="relationship" class="text-xs text-gray-500">{{ relationship && relationship.source.id === entity.id ? '→' : '←' }} {{ relationship ? relationship.type : entity.desc }}</p>
</div>
</template>

<style scoped>

</style>

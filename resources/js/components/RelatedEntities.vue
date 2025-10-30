<script setup lang="ts">
import {Entity} from "../types/entity";
import {Relationship} from "../types/relationship";
import EntityType from "./EntityType.vue";

interface Props {
    entity: Entity;
    relationship: Relationship
}

const props = defineProps<Props>();
</script>

<template>
<div class="flex items-center justify-between">
    <span class="text-sm text-gray-200">
        {{ entity.name }}
    </span>
    <EntityType :type="entity.type" />
</div>
<p class="text-xs text-gray-500">{{ relationship.source === entity.id ? '→' : '←' }} {{ relationship.type }}</p>
</template>

<style scoped>

</style>

<script setup lang="ts">
import {Entity} from "../../../types/entity";
import EntityDelete from "../EntityDelete.vue";
import RelatedEntities from "../../RelatedEntities.vue";
import EntityEdit from "../EntityEdit.vue";
import EntityType from "../../EntityType.vue";
import {useWorldStore} from "../../../stores/world";
import {computed} from "vue";
import {Relationship} from "../../../types/relationship";

const worldStore = useWorldStore();

const selectedEntity = computed(() => worldStore.selectedItemObject);
const relatedEntities = computed<
    { relationship: Relationship; entity?: Entity }[]
>(() => {
    const id = selectedEntity.value?.id;
    if (!id) return [];

    return worldStore.relatedEntities(selectedEntity.value.id);
});
</script>

<template>
    <div class="space-y-3">
        <div class="flex items-start justify-between">
            <h3>{{ (selectedEntity as Entity).name }}</h3>
            <div class="flex gap-1">
                <EntityEdit />
                <EntityDelete />
            </div>
        </div>
        <EntityType :type="selectedEntity.type" />
    </div>
    <div class="space-y-2">
        <h4 class="text-gray-400">Description</h4>
        <p class="text-sm text-gray-300">{{ selectedEntity.desc }}</p>
    </div>
    <div v-if="relatedEntities.length > 0" class="space-y-3">
        <h4 class="text-gray-400">Related Entities</h4>
        <RelatedEntities
            v-for="item in relatedEntities"
            :key="item.relationship.id"
            :entity="item.entity"
            :relationship="item.relationship"
        />
    </div>
</template>

<style scoped>

</style>

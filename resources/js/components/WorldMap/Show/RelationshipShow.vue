<script setup lang="ts">
import {useWorldStore} from "../../../stores/world";
import {computed} from "vue";
import RelatedEntities from "../../RelatedEntities.vue";
import {Relationship} from "../../../types/relationship";

const worldStore = useWorldStore();

const selectedRelationship = computed(() => worldStore.selectedItemObject);

</script>

<template>
    <div class="space-y-3">
        <div class="flex items-start justify-between">
            <h3>Relationship</h3>
            <div class="flex gap-1">
                <!-- TODO EDIT AND DELETE COMPONENT -->
            </div>
        </div>
    </div>
    <div class="space-y-2">
        <h4 class="text-gray-400">From</h4>
        <RelatedEntities :entity="(selectedRelationship as Relationship).source" />
    </div>
    <div class="space-y-2">
        <h4 class="text-gray-400">To</h4>
        <RelatedEntities :entity="(selectedRelationship as Relationship).target" />
    </div>
</template>

<style scoped>

</style>

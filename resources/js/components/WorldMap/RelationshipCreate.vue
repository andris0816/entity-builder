<script setup lang="ts">

import Button from "../Button.vue";
import SelectInput from "../SelectInput.vue";
import {computed, ref, watch} from "vue";


const props = defineProps<{
    entities: { id: number; name: string }[]
}>();

const emit = defineEmits(['submit']);

const form = ref({
    entityFrom: null as number | null,
    type: '',
    entityTo: null as number | null
});

const items = [
    'Character',
    'Location',
    'Item',
    'Event'
];

const submitForm = () => {
    emit('submit', {...form.value})
}

const filteredEntitiesTo = computed(() => {
    return props.entities.filter(entity =>
        !form.value.entityTo ? entity.id !== form.value.entityFrom : entity
    );
})

const filteredEntitiesFrom = computed(() => {
    return props.entities.filter(entity =>
        !form.value.entityFrom ? entity.id !== form.value.entityTo : entity
    );
});

watch(
    () => form.value.entityFrom,
    (newVal, oldVal) => {
        if (newVal === form.value.entityTo) form.value.entityTo = oldVal
    }
)

watch(
    () => form.value.entityTo,
    (newVal, oldVal) => {
        if (newVal === form.value.entityFrom) form.value.entityFrom = oldVal
    }
)
</script>

<template>
    <h2>Add Relationship</h2>
    <form @submit.prevent="submitForm" method="POST">
        <div class="space-y-6">
            <SelectInput :key="form.entityTo" v-model="form.entityFrom" :items="filteredEntitiesFrom" placeholder="Select entity" label="Entity From"></SelectInput>
            <SelectInput v-model="form.type" :items="items" placeholder="Select a type" label="Relationship Type"></SelectInput>
            <SelectInput :key="form.entityFrom" v-model="form.entityTo" :items="filteredEntitiesTo" placeholder="Select entity" label="Entity To"></SelectInput>
            <Button type="submit" variant="default">Add</Button>
        </div>
    </form>
</template>

<style scoped>

</style>

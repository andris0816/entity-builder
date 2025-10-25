<script setup lang="ts">

import Button from "../Button.vue";
import SelectInput from "../SelectInput.vue";
import {ref} from "vue";


defineProps<{
    entities: { id: number; name: string }[]
}>();

const emit = defineEmits(['submit']);

const form = ref({
    entityFrom: '',
    type: '',
    entityTo: ''
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
</script>

<template>
    <h2>Add Relationship</h2>
    <form @submit.prevent="submitForm" method="POST">
        <div class="space-y-6">
            <SelectInput v-model="form.entityFrom" :items="entities" placeholder="Select entity" label="Entity From"></SelectInput>
            <SelectInput v-model="form.type" :items="items" placeholder="Select a type" label="Relationship Type"></SelectInput>
            <SelectInput v-model="form.entityTo" :items="entities" placeholder="Select entity" label="Entity To"></SelectInput>
            <Button type="submit" variant="default">Add</Button>
        </div>
    </form>
</template>

<style scoped>

</style>

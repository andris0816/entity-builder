<script setup lang="ts">

import TextInput from "../TextInput.vue";
import TextArea from "../TextArea.vue";
import Button from "../Button.vue";
import {ref} from "vue";
import SelectInput from "../SelectInput.vue";

const name = ref('');
const desc = ref('');
const type = ref('');

const items = [
    'Character',
    'Location',
    'Item',
    'Event'
];
</script>

<template>
    <h2>Add Entity</h2>
    <form method="POST">
        <div class="space-y-6">
            <TextInput
                v-model="name"
                type="text"
                label="Entity Name"
                placeholder="The hero" required
            />
            <SelectInput v-model="type" :items="items" placeholder="Select a type"></SelectInput>
            <TextArea
                v-model="desc"
                label="Entity Description"
                placeholder="This hero is a..."
                rows="3"
                required
            />

            <Button type="submit" variant="default">Add</Button>
        </div>
    </form>
</template>

<style scoped>

</style>

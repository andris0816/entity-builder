<script setup lang="ts">

import TextInput from "../TextInput.vue";
import TextArea from "../TextArea.vue";
import Button from "../Button.vue";
import {ref} from "vue";
import SelectInput from "../SelectInput.vue";

const form = ref({
    name: '',
    type: '',
    desc: ''
});

const emit = defineEmits(['submit']);

const items = [
    'Character',
    'Location',
    'Item',
    'Event'
];

const submitForm = () => {
    emit('submit', {...form.value});

    form.value = {
        name: '',
        type: '',
        desc: ''
    }
}
</script>

<template>
    <h2>Add Entity</h2>
    <form @submit.prevent="submitForm" method="POST">
        <div class="space-y-6">
            <TextInput
                v-model="form.name"
                type="text"
                label="Entity Name"
                placeholder="The hero" required
            />
            <SelectInput v-model="form.type" :items="items" placeholder="Select a type" label="Type"></SelectInput>
            <TextArea
                v-model="form.desc"
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

<script setup lang="ts">

import TextInput from "../TextInput.vue";
import TextArea from "../TextArea.vue";
import CustomButton from "../CustomButton.vue";
import {ref} from "vue";
import SelectInput from "../SelectInput.vue";
import { ValidationErrors } from "../../types/ValidationErrors";
import {entityTypes} from "../../data/entityTypes";

const form = ref({
    name: '',
    type: '',
    desc: ''
});

const props = defineProps<{
    errors: ValidationErrors;
}>();

const emit = defineEmits(['submit']);

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
        <div class="space-y-6 w-full max-w-md">
            <TextInput
                v-model="form.name"
                type="text"
                label="Entity Name"
                placeholder="The hero"
                required
                :error="props.errors?.name?.[0]"
            />
            <SelectInput
                v-model="form.type"
                :items="entityTypes"
                placeholder="Select a type"
                label="Type"
                :error="props.errors?.type?.[0]"
            />
            <TextArea
                v-model="form.desc"
                label="Entity Description"
                placeholder="This hero is a..."
                rows="3"
                required
                :error="props.errors?.desc?.[0]"
            />

            <CustomButton type="submit" variant="default">Add</CustomButton>
        </div>
    </form>
</template>

<style scoped>

</style>

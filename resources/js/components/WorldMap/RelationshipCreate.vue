<script setup lang="ts">

import CustomButton from "../CustomButton.vue";
import SelectInput from "../SelectInput.vue";
import {computed, ref, watch} from "vue";
import TextArea from "../TextArea.vue";
import {ValidationErrors} from "../../types/ValidationErrors";
import {relationshipTypes} from "../../data/relationshipTypes";

const props = defineProps<{
    entities: { id: number; name: string }[];
    errors: ValidationErrors;
}>();

const emit = defineEmits(['submit']);

const form = ref({
    source: null as number | null,
    type: '',
    target: null as number | null,
    desc: ''
});

const submitForm = () => {
    emit('submit', {...form.value});

    form.value = {
        source: null as number | null,
        type: '',
        target: null as number | null,
        desc: ''
    }
}

const filteredEntitiesTo = computed(() => {
    return props.entities.filter(entity =>
        form.value.target ? true : entity.id !== form.value.source
    );
})

const filteredEntitiesFrom = computed(() => {
    return props.entities.filter(entity =>
        form.value.source ? true : entity.id !== form.value.target
    );
});

watch(
    () => form.value.source,
    (newVal, oldVal) => {
        if (newVal !== null && newVal === form.value.target) {
            form.value.target = oldVal
        }
    }
)

watch(
    () => form.value.target,
    (newVal, oldVal) => {
        if (newVal !== null && form.value.source && newVal === form.value.source) {
            form.value.source = oldVal
        }
    }
)
</script>

<template>
    <h2>Add Relationship</h2>
    <form @submit.prevent="submitForm" method="POST">
        <div class="space-y-6">
            <SelectInput
                v-model="form.source"
                :items="filteredEntitiesFrom"
                placeholder="Select entity"
                label="Entity From"
                :error="props.errors?.source?.[0]"
            />
            <SelectInput
                v-model="form.type"
                :items="relationshipTypes"
                placeholder="Select a type"
                label="Relationship Type"
                :error="props.errors?.type?.[0]"
            />
            <SelectInput
                v-model="form.target"
                :items="filteredEntitiesTo"
                placeholder="Select entity"
                label="Entity To"
                :error="props.errors?.target?.[0]"
            />
            <TextArea
                v-model="form.desc"
                label="Entity Description"
                placeholder="These 2 entities are related because..."
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

<script setup lang="ts">
import {useWorldStore} from "../../stores/world";
import {computed, ref, watch} from "vue";
import Modal from "../Modal.vue";
import TextArea from "../TextArea.vue";
import SelectInput from "../SelectInput.vue";
import {ValidationErrors} from "../../types/ValidationErrors";
import CustomButton from "../CustomButton.vue";
import {relationshipTypes} from "../../data/relationshipTypes";
import {apiFetch} from "../../utils/api";
import EditButton from "./EditButton.vue";
import {Relationship} from "../../types/relationship";

const worldStore = useWorldStore();

const selectedRelationship = computed(() => worldStore.selectedItemObject);

const filteredEntitiesTo = computed(() => {
    return worldStore.simplifiedEntities.filter(entity =>
        form.value.target ? true : entity.id !== form.value.source
    );
})

const filteredEntitiesFrom = computed(() => {
    return worldStore.simplifiedEntities.filter(entity =>
        form.value.source ? true : entity.id !== form.value.target
    );
});

const form = ref({
    source: (selectedRelationship.value as Relationship)?.source.id || '',
    type: selectedRelationship.value?.type || '',
    target: (selectedRelationship.value as Relationship)?.target.id || '',
    desc: selectedRelationship.value?.desc || '',
});

let showModal = ref(false);
let errors = ref<ValidationErrors>({});

const updateRelationship = async() => {
    try {
        const response = await apiFetch(`/relationship/${selectedRelationship.value.id}`, {
            method: "PATCH",
            body: JSON.stringify(form.value)
        });

        const data = await response.json();

        if (!response.ok) {
            if (response.status === 422) {
                errors.value = data.errors || {};
            } else {
                console.error('Server error:', data.message || data);
            }
            return;
        }

        worldStore.updateSelectedItem(form.value);

        showModal.value = false;
    } catch (err) {
        console.error('Error while updating entity', err)
    }
}

watch(selectedRelationship, (newSelectedRelationship) => {
    if (!newSelectedRelationship) return;

    form.value.source = (newSelectedRelationship as Relationship).source.id;
    form.value.type = newSelectedRelationship.type;
    form.value.target = (newSelectedRelationship as Relationship).target.id;
    form.value.desc = newSelectedRelationship.desc;
}, { immediate: true });

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
    <EditButton @click="showModal = true" />

    <Teleport to="body">
        <Modal :show="showModal" @close="showModal = false">
            <template #header>
                <h2 class="text-white text-lg leading-none font-semibold">Edit Relationship</h2>
                <p class="text-gray-400 text-sm mt-2">
                    Make changes to your relationship here. Click save when you're done.
                </p>
            </template>
            <template #default>
                <form @submit.prevent="updateRelationship" method="POST">
                    <div class="space-y-6">
                        <SelectInput
                            v-model="form.source"
                            :items="filteredEntitiesTo"
                            placeholder="Event B"
                            label="From Entity"
                            :error="errors?.type?.[0]"
                        />
                        <SelectInput
                            v-model="form.type"
                            :items="relationshipTypes"
                            placeholder="Select a type"
                            label="Relationship Type"
                            :error="errors?.type?.[0]"
                        />
                        <SelectInput
                            v-model="form.target"
                            :items="filteredEntitiesFrom"
                            placeholder="Character C"
                            label="To Entity"
                            :error="errors?.type?.[0]"
                        />
                        <TextArea
                            v-model="form.desc"
                            label="Entity Description"
                            placeholder="This hero is a..."
                            rows="3"
                            required
                            :error="errors?.desc?.[0]"
                        />
                    </div>
                </form>
            </template>
            <template #footer>
                <div class="flex justify-end gap-4">
                    <CustomButton
                        @click="showModal = false"
                        variant="dark"
                        customClass="text-white text-sm"
                    >
                        Cancel
                    </CustomButton>
                    <CustomButton
                        @click="updateRelationship"
                        type="submit"
                        variant="gradient"
                        customClass="text-sm"
                    >
                        Save Changes
                    </CustomButton>
                </div>
            </template>
        </Modal>
    </Teleport>
</template>

<style scoped>

</style>

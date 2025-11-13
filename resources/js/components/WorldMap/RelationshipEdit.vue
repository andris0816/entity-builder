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
import {toast} from "../../utils/toast";

const worldStore = useWorldStore();

const selectedRelationship = computed(() => worldStore.selectedItemObject);

const filteredEntitiesTo = computed(() => {
    const sourceId = form.value.source;

    return worldStore.simplifiedEntities.filter(entity => {
        if (entity.id === form.value.target) return true;

        if (sourceId === entity.id) return false;

        return !(sourceId && relationshipExists(sourceId as number, entity.id));
    });
})

const filteredEntitiesFrom = computed(() => {
    const targetId = form.value.target;

    return worldStore.simplifiedEntities.filter(entity => {
        if (entity.id === form.value.source) return true;

        if (targetId === entity.id) return false;

        return !(targetId && relationshipExists(entity.id, targetId as number));
    });
});

const relationshipExists = (a: number, b: number) => {
    return worldStore.relationships.some(rel =>
        (rel.source.id === a && rel.target.id === b) ||
        (rel.source.id === b && rel.target.id === a)
    );
}

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
        toast.success("Relationship updated successfully");

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
                            :items="filteredEntitiesFrom"
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
                            :items="filteredEntitiesTo"
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

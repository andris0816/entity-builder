<script setup lang="ts">
import {useWorldStore} from "../../stores/world";
import {computed, ref, watch} from "vue";
import TextInput from "../TextInput.vue";
import Modal from "../Modal.vue";
import TextArea from "../TextArea.vue";
import SelectInput from "../SelectInput.vue";
import {ValidationErrors} from "../../types/ValidationErrors";
import CustomButton from "../CustomButton.vue";
import {entityTypes} from "../../data/entityTypes";
import {apiFetch} from "../../utils/api";
import {Entity} from "../../types/entity";
import EditButton from "./EditButton.vue";
import {toast} from "../../utils/toast";

const worldStore = useWorldStore();

const selectedEntity = computed(() => worldStore.selectedItemObject);

const form = ref({
    name: (selectedEntity.value as Entity)?.name || '',
    type: selectedEntity.value?.type || '',
    desc: selectedEntity.value?.desc || '',
});

let showModal = ref(false);
let errors = ref<ValidationErrors>({});

const updateEntity = async() => {
    try {
        const response = await apiFetch(`/entity/${selectedEntity.value.id}`, {
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
        toast.success("Entity updated successfully!");

        showModal.value = false;
    } catch (err) {
        console.error('Error while updating entity', err)
    }
}

watch(selectedEntity, (newSelectedEntity) => {
    if (!newSelectedEntity) return;

    form.value.name = (newSelectedEntity as Entity).name;
    form.value.type = newSelectedEntity.type;
    form.value.desc = newSelectedEntity.desc;
}, { immediate: true });

</script>

<template>
    <EditButton @click="showModal = true" />

    <Teleport to="body">
        <Modal :show="showModal" @close="showModal = false">
            <template #header>
                <h2 class="text-white text-lg leading-none font-semibold">Edit Entity</h2>
                <p class="text-gray-400 text-sm mt-2">Start building a new fictional universe</p>
            </template>
            <template #default>
                <form @submit.prevent="updateEntity" method="POST">
                    <div class="space-y-6">
                        <TextInput
                            v-model="form.name"
                            type="text"
                            label="Entity Name"
                            placeholder="The hero"
                            required
                            :error="errors?.name?.[0]"
                        />
                        <SelectInput
                            v-model="form.type"
                            :items="entityTypes"
                            placeholder="Select a type"
                            label="Type"
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
                        @click="updateEntity"
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

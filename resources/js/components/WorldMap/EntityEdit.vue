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

const worldStore = useWorldStore();

const selectedEntity = computed(() => worldStore.selectedEntity);

const form = ref({
    name: selectedEntity.value?.name || '',
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

        worldStore.updateSelectedEntity(form.value);

        showModal.value = false;
    } catch (err) {
        console.error('Error while updating entity', err)
    }
}

watch(selectedEntity, (newSelectedEntity) => {
    if (!newSelectedEntity) return;

    form.value.name = newSelectedEntity.name;
    form.value.type = newSelectedEntity.type;
    form.value.desc = newSelectedEntity.desc;
}, { immediate: true });

</script>

<template>
    <button
        @click="showModal = true"
        type="button"
        class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium h-8 w-8 rounded-md transition-all text-gray-400 hover:text-white hover:bg-gray-800"
    >
        <svg
            xmlns="http://www.w3.org/2000/svg"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            class="lucide lucide-pen w-4 h-4"
            aria-hidden="true"
        >
            <path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"></path>
        </svg>
    </button>

    <Teleport to="body">
        <Modal :show="showModal" @close="showModal = false">
            <template #header>
                <h2 class="text-white text-lg leading-none font-semibold">Create New World</h2>
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

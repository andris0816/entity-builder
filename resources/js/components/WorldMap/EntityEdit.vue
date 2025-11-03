<script setup lang="ts">
import {useWorldStore} from "../../stores/world";
import {computed, ref} from "vue";
import TextInput from "../TextInput.vue";
import Modal from "../Modal.vue";
import TextArea from "../TextArea.vue";
import SelectInput from "../SelectInput.vue";
import {ValidationErrors} from "../../types/ValidationErrors";
import CustomButton from "../CustomButton.vue";
import {entityTypes} from "../../data/entityTypes";

const worldStore = useWorldStore();

const props = defineProps<{
    errors: ValidationErrors;
}>();

const selectedEntity = computed(() => worldStore.selectedEntity);

const form = ref({
    name: selectedEntity.value.name,
    type: selectedEntity.value.type,
    desc: selectedEntity.value.desc,
});
let showModal = ref(false);

const emit = defineEmits(['submit']);

const submitForm = () => {
    emit('submit', {...form.value});
}

</script>

<template>
    <custom-button
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
    </custom-button>

    <Teleport to="body">
        <Modal :show="showModal" @close="showModal = false">
            <template #header>
                <h2 class="text-white text-lg leading-none font-semibold">Create New World</h2>
                <p class="text-gray-400 text-sm mt-2">Start building a new fictional universe</p>
            </template>
            <template #default>
                <form @submit.prevent="submitForm" method="POST">
                    <div class="space-y-6">
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
                        @click="submitForm"
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

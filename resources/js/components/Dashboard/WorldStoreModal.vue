<script setup lang="ts">

import TextInput from "../TextInput.vue";
import Modal from "../Modal.vue";
import CustomButton from "../CustomButton.vue";
import TextArea from "../TextArea.vue";
import {ref} from "vue";
import {World} from "../../types/world";
import {apiFetch} from "../../utils/api";
import {ValidationErrors} from "../../types/validation-errors";

const name = ref('');
const desc = ref('');
const formRef = ref(null);
let showModal = ref(false);
const errors = ref<ValidationErrors>({});

const emit = defineEmits<{
    (e: 'saved', newWorld: World): void
}>();

function submitForm() {
    formRef.value.requestSubmit();
}

const saveWorld = async () => {
    errors.value = {};

    try {
        const response = await apiFetch('/world', {
            method: "POST",
            body: JSON.stringify({
                name: name.value,
                desc: desc.value,
            }),
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

        emit('saved', data.world);

        showModal.value = false;
        name.value = '';
        desc.value = '';
    } catch (err) {
        console.error("There was an error while storing new world", err);
    }
}
</script>

<template>
    <CustomButton
        @click="showModal = true"
        type="button"
        variant="gradient"
        customClass="text-sm inline-flex items-center justify-center gap-2"
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
            class="lucide lucide-plus w-4 h-4 mr-2"
            aria-hidden="true"
        >
            <path d="M5 12h14"></path>
            <path d="M12 5v14"></path>
        </svg>
        New World
    </CustomButton>

    <Teleport to="body">
        <Modal id="worldStoreModal" :show="showModal" @close="showModal = false" aria-labelledby="worldStoreModal">
            <template #header>
                <h2 class="text-white text-lg leading-none font-semibold">Create New World</h2>
                <p class="text-gray-400 text-sm mt-2">Start building a new fictional universe</p>
            </template>
            <template #default>
                <form ref="formRef" @submit.prevent="saveWorld" method="POST">
                    <div class="space-y-6">
                        <TextInput
                            v-model="name"
                            type="text"
                            label="Name"
                            placeholder="The Forgotten Shores" required
                        />
                        <TextArea
                            v-model="desc"
                            label="Description"
                            placeholder="A brief description of your world..."
                            rows="3"
                            required
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
                        Save World
                    </CustomButton>
                </div>
            </template>
        </Modal>
    </Teleport>
</template>

<style scoped>

</style>

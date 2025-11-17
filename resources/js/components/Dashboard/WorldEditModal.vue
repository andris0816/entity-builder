<script setup lang="ts">

import TextInput from "../TextInput.vue";
import Modal from "../Modal.vue";
import CustomButton from "../CustomButton.vue";
import TextArea from "../TextArea.vue";
import {ref} from "vue";
import {World} from "../../types/world";
import {apiFetch} from "../../utils/api";
import {ValidationErrors} from "../../types/validation-errors";
import {toast} from "../../utils/toast";

interface Props {
    world: World;
}

const props = defineProps<Props>();

const name = ref(props.world.name);
const desc = ref(props.world.desc);
const formRef = ref(null);
const errors = ref<ValidationErrors>({});

const emit = defineEmits<{
    (e: 'updated', updatedWorld: Partial<World>): void,
    (e: 'close'): void
}>();

function submitForm() {
    formRef.value.requestSubmit();
}

const updateWorld = async () => {
    errors.value = {};

    try {
        const formData = {
            name: name.value,
            desc: desc.value
        }
        const response = await apiFetch(`/world/${props.world.id}`, {
            method: "PATCH",
            body: JSON.stringify(formData),
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

        emit('updated', formData);
        emit('close');
        name.value = '';
        desc.value = '';
        toast.success("World updated successfully!");
    } catch (err) {
        console.error("There was an error while storing new world", err);
    }
}
</script>

<template>
    <Teleport to="body">
        <Modal :show="true" @close="emit('close')" id="worldStoreModal" aria-labelledby="worldStoreModal">
            <template #header>
                <h2 class="text-white text-lg leading-none font-semibold">Edit World</h2>
                <p class="text-gray-400 text-sm mt-2">Update {{ props.world.name }}'s information</p>
            </template>
            <template #default>
                <form ref="formRef" @submit.prevent="updateWorld">
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
                        @click="emit('close')"
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

<script setup lang="ts">

import Modal from "../Modal.vue";
import CustomButton from "../CustomButton.vue";
import {World} from "../../types/world";
import {apiFetch} from "../../utils/api";
import {toast} from "vue3-toastify";

interface Props {
    world: World;
}

const props = defineProps<Props>();
const emit = defineEmits<{
    (e: 'deleted', deletedWorldId: number): void,
    (e: 'close'): void
}>();

const deleteWorld = async () => {
    try {
        const response = await apiFetch(`/world/${props.world.id}`, {
            method: 'DELETE',
        });

        const data = await response.json();

        if (!response.ok) {
            const error = data.message;
            console.error('Failed to delete world:', error);
            return;
        }

        emit('deleted', props.world.id);
        emit('close');
        toast.success("World deleted successfully!");
    } catch (err) {
        console.error('Error while deleting entity', err)
    }
}
</script>

<template>
    <Teleport to="body">
        <Modal id="worldDeleteModal" @close="emit('close')" :show="true" aria-labelledby="worldDeleteModal">
            <template #header>
                <h2 class="text-white text-lg leading-none font-semibold">Deleting World</h2>
                <p class="text-gray-400 text-sm mt-2">Are you sure you want to delete {{ props.world.name }} world?</p>
            </template>
            <template #default>
                <form @submit.prevent="deleteWorld" method="POST">
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
                        @click="deleteWorld"
                        type="submit"
                        variant="danger"
                        customClass="text-sm"
                    >
                        Delete World
                    </CustomButton>
                </div>
            </template>
        </Modal>
    </Teleport>
</template>

<style scoped>

</style>

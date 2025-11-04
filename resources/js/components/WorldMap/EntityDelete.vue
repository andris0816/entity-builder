<script setup lang="ts">
import {useWorldStore} from "../../stores/world";
import {computed, ref} from "vue";
import Modal from "../Modal.vue";
import CustomButton from "../CustomButton.vue";
import {apiFetch} from "../../utils/api";

const worldStore = useWorldStore();
const selectedEntity = computed(() => worldStore.selectedEntity);

let showModal = ref(false);

const deleteEntity = async() => {
    try {
        const response = await apiFetch(`/entity/${selectedEntity.value.id}`, {
            method: 'DELETE',
        });

        const data = await response.json();

        if (!response.ok) {
            const error = data.message;
            console.error('Failed to delete entity:', error);
            return;
        }

        worldStore.removeSelectedEntity();
    } catch (err) {
        console.error('Error while deleting entity', err)
    }
}
</script>

<template>
    <button
        @click="showModal = true"
        type="button"
        class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium h-8 w-8 rounded-md transition-all text-red-500 hover:text-red-300 hover:bg-gray-800"
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
            class="lucide lucide-trash2 lucide-trash-2 w-4 h-4"
            aria-hidden="true"
        >
            <path d="M10 11v6"></path>
            <path d="M14 11v6"></path>
            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"></path>
            <path d="M3 6h18"></path>
            <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
        </svg>
    </button>

    <Teleport to="body">
        <Modal :show="showModal" @close="showModal = false">
            <template #header>
                <h2 class="text-white text-lg leading-none font-semibold">Deleting Entity</h2>
                <p class="text-gray-400 text-sm mt-2">Are you sure you want to delete {{ selectedEntity.name }} entity?</p>
            </template>
            <template #default>
                <form @submit.prevent="deleteEntity" method="POST">
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
                        @click="deleteEntity"
                        type="submit"
                        variant="danger"
                        customClass="text-sm"
                    >
                        Delete Entity
                    </CustomButton>
                </div>
            </template>
        </Modal>
    </Teleport>
</template>

<style scoped>

</style>

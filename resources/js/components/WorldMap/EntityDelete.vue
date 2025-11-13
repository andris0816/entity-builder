<script setup lang="ts">
import {useWorldStore} from "../../stores/world";
import {computed, ref} from "vue";
import Modal from "../Modal.vue";
import CustomButton from "../CustomButton.vue";
import {apiFetch} from "../../utils/api";
import {Entity} from "../../types/entity";
import DeleteButton from "./DeleteButton.vue";
import {toast} from "../../utils/toast";

const worldStore = useWorldStore();
const selectedEntity = computed(() => worldStore.selectedItemObject);

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

        worldStore.removeSelectedItem();
        toast.success("Entity deleted successfully!");
    } catch (err) {
        console.error('Error while deleting entity', err)
    }
}
</script>

<template>
    <DeleteButton @click="showModal = true" />

    <Teleport to="body">
        <Modal :show="showModal" @close="showModal = false">
            <template #header>
                <h2 class="text-white text-lg leading-none font-semibold">Deleting Entity</h2>
                <p class="text-gray-400 text-sm mt-2">Are you sure you want to delete {{ (selectedEntity as Entity).name }} entity?</p>
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

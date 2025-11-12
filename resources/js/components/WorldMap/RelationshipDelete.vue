<script setup lang="ts">
import {useWorldStore} from "../../stores/world";
import {computed, ref} from "vue";
import Modal from "../Modal.vue";
import CustomButton from "../CustomButton.vue";
import {apiFetch} from "../../utils/api";
import DeleteButton from "./DeleteButton.vue";

const worldStore = useWorldStore();
const selectedRelationship = computed(() => worldStore.selectedItemObject);

let showModal = ref(false);

const deleteRelationship = async() => {
    try {
        const response = await apiFetch(`/relationship/${selectedRelationship.value.id}`, {
            method: 'DELETE',
        });

        const data = await response.json();

        if (!response.ok) {
            const error = data.message;
            console.error('Failed to delete relationship:', error);
            return;
        }

        worldStore.removeSelectedItem();
    } catch (err) {
        console.error('Error while deleting relationship', err)
    }
}
</script>

<template>
    <DeleteButton @click="showModal = true" />

    <Teleport to="body">
        <Modal :show="showModal" @close="showModal = false">
            <template #header>
                <h2 class="text-white text-lg leading-none font-semibold">Deleting Relationship</h2>
                <p class="text-gray-400 text-sm mt-2">Are you sure you want to delete this relationship?</p>
            </template>
            <template #default>
                <form @submit.prevent="deleteRelationship" method="POST">
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
                        @click="deleteRelationship"
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

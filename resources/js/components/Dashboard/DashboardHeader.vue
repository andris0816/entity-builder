<script setup lang="ts">

import Button from "../Button.vue";
import Modal from "../Modal.vue";
import {ref} from "vue";
import TextInput from "../TextInput.vue";
import TextArea from "../TextArea.vue";

const name = ref('');
const desc = ref('');
let showModal = ref(false);
</script>

<template>
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-white mb-2">Your Worlds</h2>
            <p class="text-gray-400">Select a world to explore or create a new one</p>
        </div>
        <div>
            <Button @click="showModal = true" type="button" variant="gradient" customClass="text-sm inline-flex items-center justify-center gap-2">
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
            </Button>
        </div>
    </div>

    <Teleport to="body">
        <Modal :show="showModal" @close="showModal = false">
            <template #header>
                <h2 class="text-white text-lg leading-none font-semibold">Create New World</h2>
                <p class="text-gray-400 text-sm mt-2">Start building a new fictional universe</p>
            </template>
            <template #default>
                <form>
                    <div class="space-y-6">
                        <TextInput v-model="name" type="text" label="World Name" placeholder="The Forgotten Shores" required></TextInput>
                        <TextArea v-model="desc" label="World Description" placeholder="A brief description of your world..." rows="3" required></TextArea>
                    </div>
                </form>
            </template>
            <template #footer>
                <div class="flex justify-end gap-4">
                    <Button
                        @click="showModal = false"
                        variant="dark"
                        customClass="text-white text-sm"
                    >
                        Cancel
                    </Button>
                    <Button type="submit" variant="gradient" customClass="text-sm">Save World</Button>
                </div>
            </template>
        </Modal>
    </Teleport>
</template>

<style scoped>

</style>

<script setup lang="ts">
import TextInput from "../components/TextInput.vue";
import Card from "../components/Card.vue";
import Button from "../components/Button.vue";
import {ref} from "vue";
import {useRouter} from "vue-router";
import {useAuthStore} from "../auth";

const name = ref('');
const email = ref('');
const password = ref('');
const passwordConfirmation = ref('');
const authStore = useAuthStore();

const handleRegister = async () => {
    await authStore.register(name.value, email.value, password.value, passwordConfirmation.value);

    if (!authStore.error) console.error("Logged in as", authStore.user?.name);
}
</script>

<template>
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <div class="flex flex-col items-center mb-8">
                <div class="h-16 w-16 bg-gradient-to-br from-blue-400 to-purple-600 rounded-2xl p-6 flex items-center justify-center mb-4">
                    <span class="text-white text-3xl">L</span>
                </div>
                <h2 class="text-3xl text-white mb-1">Lore Explorer</h2>
                <p class="text-gray-400">Map your fictional worlds</p>
            </div>
            <Card>
                <div class="mb-6 px-6">
                    <h4 class="leading-none card-title text-medium">Create an account</h4>
                    <p class="card-desc">Start mapping your stories today</p>
                </div>
                <form @submit.prevent="handleRegister" method="POST">
                    <div class="px-6 [&:last-child]:pb-6 space-y-4">
                        <TextInput v-model="name" type="text" label="Name" placeholder="Your Name" required></TextInput>
                        <TextInput v-model="email" type="email" label="Email Address" placeholder="Your email" required></TextInput>
                        <TextInput v-model="password" type="password" label="Password" placeholder="*******" required></TextInput>
                        <TextInput v-model="passwordConfirmation" type="password" label="Password" placeholder="*******" required></TextInput>
                        <Button type="submit" variant="gradient" customClass="w-full mt-3">Create Account</Button>
                    </div>
                </form>
                <div class="flex justify-center">
                    <p class="text-md text-gray-400">Already have an account? <RouterLink to="/login" class="underline text-blue-500 hover:text-blue-200">Sign In</RouterLink></p>
                </div>
            </Card>
        </div>
    </div>
</template>

<style scoped>

</style>

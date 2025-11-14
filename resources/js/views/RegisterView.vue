<script setup lang="ts">
import TextInput from "../components/TextInput.vue";
import Card from "../components/Card.vue";
import CustomButton from "../components/CustomButton.vue";
import {ref} from "vue";
import {ValidationErrors} from "../types/ValidationErrors";
import {useAuthStore} from "../auth";
import {toast} from "../utils/toast";

const name = ref('');
const email = ref('');
const password = ref('');
const passwordConfirmation = ref('');
const errors = ref<ValidationErrors>({});
const authStore = useAuthStore();

const handleRegister = async () => {
    errors.value = {};

    try {
        await authStore.register(
            name.value,
            email.value,
            password.value,
            passwordConfirmation.value
        );

        if (authStore.error) {
            errors.value = authStore.error;
        }
    } catch (e) {
        toast.error("Unexpected error occurred");
    }
};
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
                        <TextInput
                            v-model="name"
                            type="text"
                            label="Name"
                            placeholder="Your Name"
                            :error="errors?.name?.[0]"
                            required
                        />
                        <TextInput
                            v-model="email"
                            type="email"
                            label="Email Address"
                            placeholder="Your email"
                            :error="errors?.email?.[0]"
                            required
                        />
                        <TextInput
                            v-model="password"
                            type="password"
                            label="Password"
                            placeholder="*******"
                            :error="errors?.password?.[0]"
                            required
                        />
                        <TextInput
                            v-model="passwordConfirmation"
                            type="password"
                            label="Password Confirmation"
                            placeholder="*******"
                            :error="errors?.passwordConfirmation?.[0]"
                            required
                        />
                        <CustomButton
                            type="submit"
                            variant="gradient"
                            customClass="w-full mt-3"
                        >
                            Create Account
                        </CustomButton>
                    </div>
                </form>
                <div class="flex justify-center">
                    <p class="text-md text-gray-400">
                        Already have an account?
                        <RouterLink
                            to="/login"
                            class="underline text-blue-500 hover:text-blue-200"
                        >
                            Sign In
                        </RouterLink>
                    </p>
                </div>
            </Card>
        </div>
    </div>
</template>

<style scoped>

</style>

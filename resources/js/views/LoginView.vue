<script setup lang="ts">
import CustomButton from "../components/CustomButton.vue";
import Card from "../components/Card.vue";
import TextInput from "../components/TextInput.vue";
import {ref} from "vue";
import {useAuthStore} from "../auth";
import {ValidationErrors} from "../types/ValidationErrors";

const authStore = useAuthStore();

const email = ref('');
const password = ref('');
const errors = ref<ValidationErrors>({});

const handleLogin = async () => {
    await authStore.login(email.value, password.value);

    if (authStore.error !== null) {
        errors.value = authStore.error;
    }
}
</script>

<template>
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <div class="flex flex-col items-center mb-8">
                <div class="h-16 w-16 bg-gradient-to-br from-blue-400 to-purple-600 rounded-2xl p-6 flex items-center justify-center mb-4">
                    <span class="text-white text-3xl">L</span>
                </div>
                <h2 class="text-3xl text-white mb-1">Welcome Back</h2>
                <p class="text-gray-400">Sign in to your account to continue</p>
            </div>
            <Card>
                <div class="mb-6 px-6">
                    <h4 class="leading-none card-title text-medium">Create an account</h4>
                    <p class="card-desc">Start mapping your stories today</p>
                </div>
                <form @submit.prevent="handleLogin" method="POST">
                    <div class="px-6 [&:last-child]:pb-6 space-y-4">
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
                        <CustomButton
                            type="submit"
                            variant="gradient"
                            customClass="w-full mt-3"
                        >
                            Sign In
                        </CustomButton>
                    </div>
                </form>
                <div class="flex justify-center">
                    <p class="text-md text-gray-400">Don't have an account? <RouterLink to="/register" class="underline text-blue-500 hover:text-blue-200">Sign Up</RouterLink></p>
                </div>
            </Card>
        </div>
    </div>
</template>

<style scoped>

</style>

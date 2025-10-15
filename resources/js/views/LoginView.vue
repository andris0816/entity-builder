<script setup lang="ts">
import Button from "../components/Button.vue";
import Card from "../components/Card.vue";
import TextInput from "../components/TextInput.vue";
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
                <form>
                    <div class="px-6 [&:last-child]:pb-6 space-y-4">
                        <TextInput v-model="email" type="email" label="Email Address" placeholder="Your email" required></TextInput>
                        <TextInput v-model="password" type="password" label="Password" placeholder="*******" required></TextInput>
                        <Button variant="gradient" class="w-full mt-3">Sign In</Button>
                    </div>
                </form>
            </Card>
        </div>
    </div>
</template>

<style scoped>

</style>

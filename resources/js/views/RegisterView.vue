<script setup>

import TextInput from "../components/TextInput.vue";
import Card from "../components/Card.vue";
import Button from "../components/Button.vue";
</script>

<template>
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <div class="flex flex-col items-center mb-8">Placeholder for the title part</div>
            <Card>
                <div class="mb-6 px-6">
                    <h4 class="leading-none card-title text-medium">Create an account</h4>
                    <p class="card-desc">Start mapping your stories today</p>
                </div>
                <form>
                    <div class="px-6 [&:last-child]:pb-6 space-y-4">
                        <TextInput v-model="name" type="text" label="Name" placeholder="Your Name" required></TextInput>
                        <TextInput v-model="email" type="email" label="Email Address" placeholder="Your email" required></TextInput>
                        <TextInput v-model="password" type="password" label="Password" placeholder="*******" required></TextInput>
                        <TextInput v-model="password_confirmation" type="password" label="Password" placeholder="*******" required></TextInput>
                        <Button variant="gradient" class="w-full">Sign In</Button>
                    </div>
                </form>
            </Card>
        </div>
    </div>
</template>

<style scoped>

</style>

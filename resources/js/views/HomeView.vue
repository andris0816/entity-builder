<script setup lang="ts">
    import Card from "../components/Card.vue";
    import {entities} from "../data/entityData";
    import HeroSection from "../components/HeroSection.vue";
    import {cardData} from "../data/homeCardData";
    import ButtonLink from "../components/ButtonLink.vue";
    import {useAuthStore} from "../auth";

    const authStore = useAuthStore();
</script>

<template>
    <div>
        <HeroSection :entities="entities"/>
        <section class="py-20 bg-gray-950">
            <div class="max-w-5xl mx-auto px-6">
                <h2 class="text-white mb-3">What you can do</h2>
                <p class="text-gray-400 mb-12">
                    Just a simple tool for organizing your fictional stuff. Nothing fancy.
                </p>
                <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-6">
                    <Card v-for="card in cardData" customClass="hover:border-gray-700">
                        <h3 class="card-title">{{ card.title }}</h3>
                        <p class="card-desc">
                            {{ card.description }}
                        </p>
                    </Card>
                </div>
            </div>
        </section>
        <section class="bg-gray-900 py-24">
            <div class="max-w-4xl mx-auto px-6 text-center">
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
                    class="lucide lucide-book w-16 h-16 text-purple-400 mx-auto mb-6"
                    aria-hidden="true"
                >
                    <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20"></path>
                </svg>
                <h2 class="text-white mb-6">
                    Ready to Start Building?
                </h2>
                <p class="text-gray-400 text-xl mb-6">
                    Join creators worldwide who use Entity Builder to bring their fictional worlds to life.
                </p>
                <ButtonLink v-if="! authStore.user"
                    href="/register"
                    variant="gradient"
                >
                    Create Your First World
                </ButtonLink>
            </div>
        </section>
    </div>
</template>

<style scoped>

</style>

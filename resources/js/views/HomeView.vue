<script setup>
    import Card from "../components/Card.vue";
    import {entities} from "../data/entityData.js";
    import Button from "../components/Button.vue";
    import HeroSection from "../components/HeroSection.vue";

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
                <div class="grid md:grid-cols-2 gap-6">
                    <Card customClass="hover:border-gray-700">
                        <h3 class="card-title">Create entities</h3>
                        <p class="card-desc">
                            Add characters, locations, items, events—whatever exists in your world.
                            Each type gets a different color so you can tell them apart.
                        </p>
                    </Card>
                    <Card customClass="hover:border-gray-700">
                        <h3 class="card-title">Draw connections</h3>
                        <p class="card-desc">
                            ink entities together. Who owns what, where things happen, how characters know each other.
                            The relationships make your world feel more real.
                        </p>
                    </Card>
                    <Card customClass="hover:border-gray-700">
                        <h3 class="card-title">Move things around</h3>
                        <p class="card-desc">
                            Drag nodes wherever you want.
                            There's no "right" way to organize it— just arrange things in a way that makes sense to you.
                        </p>
                    </Card>
                    <Card customClass="hover:border-gray-700">
                        <h3 class="card-title">Keep track of multiple worlds</h3>
                        <p class="card-desc">
                            Working on different stories or campaigns?
                            Each world is separate.
                            No worrying about accidentally mixing up your sci-fi and fantasy universes.
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
                <h2 class="text-white mb-6">Ready to Start Building?</h2>
                <p class="text-gray-400 text-xl mb-6">Join creators worldwide who use Lore Explorer to bring their fictional worlds to life.</p>
                <Button
                    customClass="
                    bg-gradient-to-r
                    from-blue-500
                    to-purple-400
                    hover:from-blue-600
                    hover:to-purple-700
                    shadow-2xl
                    shadow-blue-500/50
                    text-black"

                    text="Create Your First World"
                />
            </div>
        </section>
    </div>
</template>

<style scoped>

</style>

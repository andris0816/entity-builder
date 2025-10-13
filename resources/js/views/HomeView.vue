<script setup>
    import Card from "../components/Card.vue";
</script>

<template>
    <div>
        <nav class="border-b border-gray-800 bg-gray-900/50 backdrop-blur-sm sticky top-0 z-50">
            <div class="mx-auto px-6 py-4 flex items-center justify-between">
                <RouterLink to="/Profile">Profile</RouterLink>
                <RouterLink to="/register">Sign in</RouterLink>
            </div>
        </nav>
        <section class="relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-600/20 via-purple-600/20 to-pink-600/20 blur-3xl"></div>
            <div class="relative max-w-7xl mx-auto px-6 py-24 md:py-32">
                <div class="text-center max-w-4xl mx-auto">
                    <div class="inline-flex justify-center items-center gap-2 my-10 py-2 px-4 border border-gray-700 bg-gray-800/50 rounded-4xl">
                        <svg class="lucide lucide-sparkles w-4 h-4 text-purple-400"
                             xmlns="http://www.w3.org/2000/svg"
                             width="24"
                             height="24"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2"
                             stroke-linecap="round"
                             stroke-linejoin="round"
                             aria-hidden="true"
                        >
                            <path d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z"></path>
                            <path d="M20 2v4"></path>
                            <path d="M22 4h-4"></path>
                            <circle cx="4" cy="20" r="2"></circle>
                        </svg>
                        <span class="ml-auto">Worldbuilding Made Visual</span>
                    </div>
                    <h1 class="text-white mb-6 text-5xl md:text-6xl lg:text-7xl">Map Your
                        <span class="bg-gradient-to-r from-blue-400 via-purple-400 to-pink-400 bg-clip-text text-transparent">Fictional Worlds</span>
                    </h1>
                    <p class="text-xl max-w-2xl mx-auto opacity-65">
                        The ultimate tool for writers, game designers, and creators to visualize and organize complex story universes with beautiful interactive graphs.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-3 py-8 mb-16">
                        <button class="bg-gradient-to-r font-medium from-blue-500 to-purple-400 hover:from-blue-600 hover:to-purple-700 text-lg shadow-2xl shadow-blue-500/50 border rounded-lg px-3 py-2 text-black">Get Started Free</button>
                        <button class="border rounded-lg font-medium px-3 py-2 border-gray-600 g-gray-800/50 text-lg hover:bg-gray-800">Sign in</button>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        <div class="group">
                            <div class="bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl p-6 shadow-2xl shadow-blue-500/30 hover:shadow-blue-500/50 transition-all hover:scale-105">
                                <div class="w-12 h-12 rounded-full bg-white/50 mx-auto"></div>
                                <p class="text-sm text-center mt-2">Character</p>
                                <p class="text-xs text-center">Heroes & Villains</p>
                            </div>
                        </div>
                        <div class="group">
                            <div class="bg-gradient-to-br from-green-400 to-green-600 rounded-2xl p-6 shadow-2xl shadow-blue-500/30 hover:shadow-blue-500/50 transition-all hover:scale-105">
                                <div class="w-12 h-12 rounded-full bg-white/50 mx-auto"></div>
                                <p class="text-sm text-center mt-2">Location</p>
                                <p class="text-xs text-center">Places & Realms</p>
                            </div>
                        </div>
                        <div class="group">
                            <div class="bg-gradient-to-br from-orange-400 to-orange-600 rounded-2xl p-6 shadow-2xl shadow-blue-500/30 hover:shadow-blue-500/50 transition-all hover:scale-105">
                                <div class="w-12 h-12 rounded-full bg-white/50 mx-auto"></div>
                                <p class="text-sm text-center mt-2">Item</p>
                                <p class="text-xs text-center">Artifacts & Tools</p>
                            </div>
                        </div>
                        <div class="group">
                            <div class="bg-gradient-to-br from-purple-400 to-purple-600 rounded-2xl p-6 shadow-2xl shadow-blue-500/30 hover:shadow-blue-500/50 transition-all hover:scale-105">
                                <div class="w-12 h-12 rounded-full bg-white/50 mx-auto"></div>
                                <p class="text-sm text-center mt-2">Event</p>
                                <p class="text-xs text-center">Battles & Moments</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-8 border border-gray-800 rounded-xl p-6 bg-gray-900">
                        <div class="flex justify-between items-center">
                            <div class="h-16 w-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl p-6 flex items-center justify-center">
                                <span class="text-white text-xs">Aria</span>
                            </div>
                            <div class="flex-1 border-t-2 border-dashed border-gray-600 relative">
                                <span class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-gray-900 px-2 text-xs text-gray-400">owns</span>
                            </div>
                            <div class="h-16 w-16 bg-gradient-to-br from-orange-400 to-orange-600 rounded-2xl p-6 flex items-center justify-center">
                                <span class="text-white text-xs">Sword</span>
                            </div>
                            <div class="flex-1 border-t-2 border-dashed border-gray-600 relative">
                                <span class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-gray-900 px-2 text-xs text-gray-400">used in</span>
                            </div>
                            <div class="h-16 w-16 bg-gradient-to-br from-purple-400 to-purple-600 rounded-2xl p-6 flex items-center justify-center">
                                <span class="text-white text-xs">Battle</span>
                            </div>
                        </div>

                        <p class="mt-8 text-sm text-gray-400">Connect entities with meaningful relationships to build your story</p>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-20 bg-gray-950">
            <div class="max-w-5xl mx-auto px-6">
                <h2 class="text-white mb-3">What you can do</h2>
                <p class="text-gray-400 mb-12">
                    Just a simple tool for organizing your fictional stuff. Nothing fancy.
                </p>
                <div class="grid md:grid-cols-2 gap-6">
                    <Card>
                        <template #title>Create entities</template>
                        <template #desc>
                            Add characters, locations, items, events—whatever exists in your world.
                            Each type gets a different color so you can tell them apart.
                        </template>
                    </Card>
                    <Card>
                        <template #title>Draw connections</template>
                        <template #desc>
                            Link entities together. Who owns what, where things happen, how characters know each other.
                            The relationships make your world feel more real.
                        </template>
                    </Card>
                    <Card>
                        <template #title>Move things around</template>
                        <template #desc>
                            Drag nodes wherever you want.
                            There's no "right" way to organize it— just arrange things in a way that makes sense to you.
                        </template>
                    </Card>
                    <Card>
                        <template #title>Keep track of multiple worlds</template>
                        <template #desc>
                            Working on different stories or campaigns?
                            Each world is separate.
                            No worrying about accidentally mixing up your sci-fi and fantasy universes.
                        </template>
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
                <button
                    class="
                    bg-gradient-to-r
                    font-medium
                    from-blue-500
                    to-purple-400
                    hover:from-blue-600
                    hover:to-purple-700
                    text-lg shadow-2xl
                    shadow-blue-500/50
                    border rounded-lg
                    px-3 py-2
                    text-black"
                >
                    Create Your First World
                </button>
            </div>
        </section>
    </div>
</template>

<style scoped>

</style>

<script setup>
    import Card from "../components/Card.vue";
</script>

<template>
    <div class="bg-gray-950">
        <nav class="border-b border-gray-800 bg-gray-900/50 backdrop-blur-sm sticky top-0 z-50">
            <div class="mx-auto px-6 py-4 flex items-center justify-between">
                <RouterLink to="/Profile">Profile</RouterLink>
                <RouterLink to="/register">Sign in</RouterLink>
            </div>
        </nav>
        <div class="relative max-w-7xl mx-auto px-6 py-24 md:py-32">
            <div class="text-center">
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
                    <button class="bg-gradient-to-r from-blue-500 to-purple-400 hover:from-blue-600 hover:to-purple-700 text-lg shadow-2xl shadow-blue-500/50 border rounded-lg px-3 py-2 text-black">Get Started Free</button>
                    <button class="border rounded-lg px-3 py-2 border-gray-600 g-gray-800/50 text-lg hover:bg-gray-800">Sign in</button>
                </div>
                <div class="flex justify-center gap-3 py-24 bg-gradient-to-b from-gray-950 to-gray-900">
                    <Card></Card>
                    <Card></Card>
                    <Card></Card>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>

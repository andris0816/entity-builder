<script setup lang="ts">

import WorldCard from "../components/Dashboard/WorldCard.vue";
import DashboardHeader from "../components/Dashboard/DashboardHeader.vue";

</script>

<template>
    <div class="max-w-7xl mx-auto px-6 py-12">
        <DashboardHeader />
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <WorldCard></WorldCard>
            <WorldCard></WorldCard>
            <WorldCard></WorldCard>
            <WorldCard></WorldCard>
            <WorldCard></WorldCard>
            <WorldCard></WorldCard>
        </div>
    </div>
</template>

<style scoped>

</style>

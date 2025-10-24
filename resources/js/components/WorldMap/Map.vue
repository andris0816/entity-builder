<script setup lang="ts">
    import * as d3 from 'd3';
    import {onMounted, onUnmounted, ref} from "vue";

    const graphContainer = ref(null);

    const nodes = [
        {index: 0, x: 12, y: 12, vx: 10, vy: 10},
        {index: 1, x: 2, y: 1, vx: 41, vy: 21},
        {index: 2, x: 43, y: 23, vx: 10, vy: 10},
        {index: 3, x: 32, y: 7, vx: 10, vy: 10},
        {index: 4, x: 21, y: 12, vx: 10, vy: 10},
    ];

    let simulation, svg, zoomG;

    onMounted(() => {
        const width = 800;
        const height = 600;

        svg = d3.select(graphContainer.value)
            .append('svg')
            .attr('width', width)
            .attr('height', height);

        simulation = d3.forceSimulation(nodes)
            .force("charge", d3.forceManyBody())
            .force("center", d3.forceCenter(width/2, height/2));

        zoomG = svg.append('g');

        const node = zoomG.selectAll('circle')
            .data(nodes)
            .enter()
            .append('circle')
            .attr('r', 10)
            .attr('fill', '#69b3a2')
            .join('circle');

        function ticked() {
            node
                .attr('cx', d => d.x)
                .attr('cy', d => d.y);
        }

        simulation.on("tick", ticked)
    });

    onUnmounted(() => {
       simulation.stop();
    });
</script>

<template>
    <div>
        <div ref="graphContainer"></div>
    </div>
</template>

<style scoped>

</style>

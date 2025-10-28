<script setup lang="ts">
    import * as d3 from 'd3';
    import {computed, onMounted, onUnmounted, ref} from "vue";
    import {useWorldStore} from "../../stores/world";

    const graphContainer = ref(null);
    const worldStore = useWorldStore();

    const entities = computed(() => worldStore.entities);
    const relationships = computed(() => worldStore.relationships);

    let simulation, svg, zoomG;

    onMounted(() => {
        const width = 800;
        const height = 600;

        svg = d3.select(graphContainer.value)
            .append('svg')
            .attr('width', width)
            .attr('height', height);

        simulation = d3.forceSimulation(entities.value)
            .force("charge", d3.forceManyBody())
            .force("center", d3.forceCenter(width/2, height/2))
            .force("link", d3.forceLink(relationships.value).id((d): any => d.id).distance(120));

        zoomG = svg.append('g');

        const link = zoomG.append('g')
            .selectAll('line')
            .data(relationships.value)
            .enter()
            .append('line')
            .attr('stroke', '#999')
            .attr('stroke-width', 2);

        const nodeGroups = zoomG.selectAll('g.entity-group')
            .data(entities.value, d => d.id)
            .enter()
            .append('g')
            .attr('class', 'entity-group');

        nodeGroups.append('circle')
            .attr('r', 25)
            .attr('fill', '#69b3a2') // TODO change this to randomized later
            .join('circle');

        nodeGroups.append('text')
            .text(d => d.name)
            .attr('text-anchor', 'middle')
            .attr('dy', '.3em')


        function ticked() {
            link
                .attr('x1', d => d.source.x)
                .attr('y1', d => d.source.y)
                .attr('x2', d => d.target.x)
                .attr('y2', d => d.target.y);

            nodeGroups.attr('transform', d => `translate(${d.x},${d.y})`);
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

<script setup lang="ts">
    import * as d3 from 'd3';
    import {computed, onMounted, onUnmounted, ref} from "vue";
    import {useWorldStore} from "../../stores/world";
    import {colorHexCodes} from "../../data/entityColor";

    const graphContainer = ref(null);
    const worldStore = useWorldStore();

    const entities = computed(() => worldStore.entities);
    const relationships = computed(() => worldStore.relationships);

    let simulation: any, svg: any, zoomG: any;

    onMounted(() => {
        const width = 1200;
        const height = 900;

        svg = d3.select(graphContainer.value)
            .append('svg')
            .attr('width', width)
            .attr('height', height);

        simulation = d3.forceSimulation(entities.value)
            .force("charge", d3.forceManyBody().strength(-30))
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
            .attr('class', 'entity-group')
            .attr('style', 'cursor: pointer;');

        nodeGroups.append('circle')
            .attr('r', 50)
            .attr('fill', d => colorHexCodes[d.type])
            .join('circle');

        nodeGroups.append('text')
            .text(d => d.name)
            .attr('text-anchor', 'middle')
            .attr('dy', '.3em')
            .attr('fill', 'white');

        const dragBehavior = d3.drag();
        dragBehavior.on('start', dragStarted);
        dragBehavior.on('drag', dragged);
        nodeGroups.call(dragBehavior);

        const zoom = d3.zoom();
        zoom.extent([[0, 0], [width, height]]);
        zoom.scaleExtent([1, 8]);
        zoom.on('zoom', zoomed);

        zoomG.call(zoom);

        function ticked() {
            link
                .attr('x1', d => d.source.x)
                .attr('y1', d => d.source.y)
                .attr('x2', d => d.target.x)
                .attr('y2', d => d.target.y);

            nodeGroups.attr('transform', d => `translate(${d.x},${d.y})`);
        }

        function dragStarted(event: any) {
            if (!event.active) simulation.alphaTarget(0.3).restart();
            event.subject.fx = event.subject.x;
            event.subject.fy = event.subject.y;
        }

        function dragged(event: any) {
            event.subject.fx = event.x;
            event.subject.fy = event.y;
        }

        function zoomed({ transform }) {
            zoomG.attr('transform', transform);
        }

        simulation.on("tick", ticked);

        nodeGroups.on('click', function(event, d) {
            worldStore.selectEntity(d.id);
        });
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

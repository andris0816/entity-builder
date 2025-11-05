<script setup lang="ts">
    import * as d3 from 'd3';
    import {computed, onMounted, onUnmounted, ref, watch} from "vue";
    import {useWorldStore} from "../../stores/world";
    import {colorHexCodes} from "../../data/entityColor";

    const graphContainer = ref(null);
    const worldStore = useWorldStore();

    const entities = computed(() => worldStore.entities);
    const relationships = computed(() => worldStore.relationships);

    let simulation: any, svg: any, zoomG: any, link: any, nodeGroups: any, nodeLayer: any, linkLayer: any;

    const width = 1200;
    const height = 900;

    const dragBehavior = d3.drag();

    dragBehavior.on('start', (event: any) => {
        if (!event.active) simulation.alphaTarget(0.3).restart();
        event.subject.fx = event.subject.x;
        event.subject.fy = event.subject.y;
    });

    dragBehavior.on('drag', (event: any) => {
        event.subject.fx = event.x;
        event.subject.fy = event.y;
    });

    dragBehavior.on('end', (event: any) => {
        if (!event.active) simulation.alphaTarget(0);
        event.subject.fx = null;
        event.subject.fy = null;
    });


    function initializeGraph() {
        svg = d3.select(graphContainer.value)
            .append('svg')
            .attr('width', width)
            .attr('height', height);

        zoomG = svg.append('g');
        linkLayer = zoomG.append('g').attr('class', 'links');
        nodeLayer = zoomG.append('g').attr('class', 'nodes');

        link = linkLayer.append('g')
            .selectAll('line')
            .data(relationships.value)
            .enter()
            .append('line')
            .attr('stroke', '#999')
            .attr('stroke-width', 2);

        nodeGroups = nodeLayer.selectAll('g.entity-group')
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

        nodeGroups.call(dragBehavior);

        simulation = d3.forceSimulation(entities.value.slice())
            .force("charge", d3.forceManyBody().strength(-150).distanceMax(150))
            .force("center", d3.forceCenter(width/2, height/2))
            .force("link", d3.forceLink(relationships.value).id((d): any => d.id).distance(300));

        simulation.alphaDecay(0.05);
        simulation.on("tick", ticked);

        const zoom = d3.zoom();
        zoom.extent([[0, 0], [width, height]]);
        zoom.scaleExtent([1, 4]);
        zoom.on('zoom', ({transform}) => {
            zoomG.attr('transform', transform);
        });

        zoomG.call(zoom);

        nodeGroups.on('click', function(event, d) {
            worldStore.selectEntity(d.id);
        });

        simulation.alpha(1).restart();
    }

    function ticked() {
        requestAnimationFrame(() => {
            link
                .attr('x1', d => d.source.x)
                .attr('y1', d => d.source.y)
                .attr('x2', d => d.target.x)
                .attr('y2', d => d.target.y);

            nodeGroups.attr('transform', d => `translate(${d.x},${d.y})`);

        });
    }

    onMounted(() => {
        initializeGraph();
    });

    onUnmounted(() => {
       simulation.stop();
    });

    watch([entities, relationships], ([newEntities, newRelationships]) => {
        link = linkLayer.selectAll('line')
            .data(newRelationships.slice(), d => `${d.source.id}-${d.target.id}`)
            .join(
                enter => enter.append('line')
                    .attr('stroke', '#999')
                    .attr('stroke-width', 2),
                update => update,
                exit => exit.remove()
            );

        nodeGroups = nodeLayer.selectAll('g.entity-group')
            .data(newEntities.slice(), d => d.id)
            .join(
                enter => {
                    const g = enter.append('g');

                    g.attr('class', 'entity-group')
                        .attr('style', 'cursor: pointer;')
                        .call(dragBehavior)
                        .on('click', (event, d) => worldStore.selectEntity(d.id));

                    g.append('circle')
                        .attr('r', 50)
                        .attr('fill', (d: any) => colorHexCodes[d.type]);

                    g.append('text')
                        .text(d => d.name)
                        .attr('text-anchor', 'middle')
                        .attr('dy', '.3em')
                        .attr('fill', 'white');

                    return g;
                },
                update => {
                    update.select('circle')
                        .attr('r', 50)
                        .attr('fill', d => colorHexCodes[d.type]);

                    update.select('text')
                        .text(d => d.name)
                        .attr('text-anchor', 'middle')
                        .attr('dy', '.3em')
                        .attr('fill', 'white');

                    return update;
                },
                exit => exit.remove()
            );

        simulation.nodes(newEntities.slice());
        simulation.force('link').links(newRelationships.slice());
        simulation.alpha(1).restart();
    }, { deep: true });
</script>

<template>
    <div>
        <div ref="graphContainer"></div>
    </div>
</template>

<style scoped>

</style>

<script setup lang="ts">
    import * as d3 from 'd3';
    import {computed, onMounted, onUnmounted, ref, watch} from "vue";
    import {useWorldStore} from "../../stores/world";
    import {colorHexCodes} from "../../data/entityColor";

    const NODE_RADIUS = 40;
    const NEUTRAL_FILL = '#1F2937';
    const graphContainer = ref(null);
    const worldStore = useWorldStore();

    const entities = computed(() => worldStore.entities);
    const relationships = computed(() => worldStore.relationships);

    let simulation: any,
        svg: any,
        zoomG: any,
        link: any,
        nodeGroups: any,
        nodeLayer: any,
        linkLayer: any;

    const width = 1320;
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
            .attr('viewBox', `0 0 ${width} ${height}`)
            .attr('preserveAspectRatio', 'xMidYMid meet')
            .style('width', '100%')
            .style('height', '100%')
            .attr('role', 'img')
            .attr('aria-label', 'Network graph showing entities and their relationships')
            .attr('aria-describedby', 'graph-desc');

        svg.append('title').text('Lore Explorer network graph');
        svg.append('desc')
            .attr('id', 'graph-desc')
            .text('This graph shows characters, locations, items and events as nodes, with lines indicating relationships between them.');

        zoomG = svg.append('g');
        linkLayer = zoomG.append('g').attr('class', 'links');
        nodeLayer = zoomG.append('g').attr('class', 'nodes');

        link = linkLayer.selectAll('g.link-group')
            .data(relationships.value)
            .enter()
            .append('g')
            .attr('class', 'link-group relationship-group')

        link.append('line')
            .attr('class', 'hit-line')
            .attr('stroke', 'transparent')
            .attr('stroke-width', 20)
            .style('cursor', 'pointer');

        link.append('line')
            .attr('tabindex', 0)
            .attr('aria-label', d => `${d.source.name} ${d.type} ${d.target.name}`)
            .attr('class', 'visible-line')
            .attr('stroke', '#6B7280')
            .attr('stroke-width', 2);

        nodeGroups = nodeLayer.selectAll('g.entity-group')
            .data(entities.value, d => d.id)
            .enter()
            .append('g')
            .attr('tabindex', 0)
            .attr('aria-label', d => `${d.type}: ${d.name}`)
            .attr('class', 'entity-group')
            .attr('style', 'cursor: pointer;');

        nodeGroups.append('circle')
            .attr('r', NODE_RADIUS)
            .attr('fill', NEUTRAL_FILL)
            .attr('stroke', d => colorHexCodes[d.type])
            .attr('stroke-width', 3)
            .join('circle');

        nodeGroups.append('text')
            .text(d => d.name)
            .attr('text-anchor', 'middle')
            .attr('dy', '.3em')
            .attr('fill', 'white');

        nodeGroups.call(dragBehavior);

        const rect = graphContainer.value.getBoundingClientRect();

        simulation = d3.forceSimulation(entities.value.slice())
            .force("charge", d3.forceManyBody().strength(-150).distanceMax(150))
            .force("center", d3.forceCenter(rect.width / 2, rect.height / 2))
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
            nodeGroups.classed('selected', false);
            link.classed('selected', false);
            d3.select(this).classed('selected', true);

            worldStore.selectItem('entity', d.id);
        });

        nodeGroups.on('keydown', function(event, d) {
            if (event.key === 'Enter' || event.key === ' ') {
                worldStore.selectItem('entity', d.id);
                nodeGroups.classed('selected', false);
                link.classed('selected', false);
                d3.select(this).classed('selected', true);
            }
        });

        link.on('keydown', function(event, d) {
            if (event.key === 'Enter' || event.key === ' ') {
                link.classed('selected', false);
                nodeGroups.classed('selected', false);
                d3.select(this).classed('selected', true);

                worldStore.selectItem('relationship', d.id);
            }
        });

        link.on('click', function(event, d) {
            link.classed('selected', false);
            nodeGroups.classed('selected', false);
            d3.select(this).classed('selected', true);

            worldStore.selectItem('relationship', d.id);
        });

        window.addEventListener('resize', () => {
            const rect = graphContainer.value.getBoundingClientRect();
            simulation.force('center', d3.forceCenter(rect.width / 2, rect.height / 2));
            simulation.alpha(1).restart();
        });

        simulation.alpha(1).restart();
    }

    function ticked() {
        requestAnimationFrame(() => {
            link.select('.hit-line')
                .attr('x1', d => d.source.x)
                .attr('y1', d => d.source.y)
                .attr('x2', d => d.target.x)
                .attr('y2', d => d.target.y);

            link.select('.visible-line')
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
        link = linkLayer.selectAll('g.link-group')
            .data(newRelationships.slice(), d => `${d.source.id}-${d.target.id}`)
            .join(
                enter => {
                    const g = enter.append('g')
                        .attr('class', 'link-group relationship-group')
                        .attr('tabindex', 0)
                        .attr('aria-label', d => `${d.source.name} ${d.type} ${d.target.name}`);

                    g.on('keydown', function(event, d) {
                        if (event.key === 'Enter' || event.key === ' ') {
                            link.classed('selected', false);
                            nodeGroups.classed('selected', false);
                            d3.select(this).classed('selected', true);

                            worldStore.selectItem('relationship', d.id);
                        }
                    });

                    g.append('line')
                        .attr('class', 'hit-line')
                        .attr('stroke', 'transparent')
                        .attr('stroke-width', 20)
                        .style('cursor', 'pointer')
                        .on('click', function(event, d) {
                            nodeGroups.classed('selected', false);
                            link.classed('selected', false);
                            d3.select(this).classed('selected', true);
                            worldStore.selectItem('relationship', d.id);
                        });

                    g.append('line')
                        .attr('class', 'visible-line')
                        .attr('stroke', '#6B7280')
                        .attr('stroke-width', 2);

                    return g;
                },
                update => update,
                exit => exit.remove()
            );

        nodeGroups = nodeLayer.selectAll('g.entity-group')
            .data(newEntities.slice(), d => d.id)
            .join(
                enter => {
                    const g = enter.append('g');

                    g.attr('class', 'entity-group')
                        .attr('tabindex', 0)
                        .attr('aria-label', d => `${d.type}: ${d.name}`)
                        .attr('style', 'cursor: pointer;')
                        .call(dragBehavior)
                        .on('click', function (event, d) {
                            nodeGroups.classed('selected', false);
                            link.classed('selected', false);
                            d3.select(this).classed('selected', true);
                            worldStore.selectItem('entity', d.id);
                        });

                    g.on('keydown', function(event, d) {
                        if (event.key === 'Enter' || event.key === ' ') {
                            worldStore.selectItem('entity', d.id);
                            nodeGroups.classed('selected', false);
                            link.classed('selected', false);
                            d3.select(this).classed('selected', true);
                        }
                    });

                    g.append('circle')
                        .attr('r', NODE_RADIUS)
                        .attr('fill', NEUTRAL_FILL)
                        .attr('stroke', d => colorHexCodes[d.type])
                        .attr('stroke-width', 3);

                    g.append('text')
                        .text(d => d.name)
                        .attr('text-anchor', 'middle')
                        .attr('dy', '.3em')
                        .attr('fill', 'white');

                    return g;
                },
                update => {
                    update.select('circle')
                        .attr('r', NODE_RADIUS)
                        .attr('fill', NEUTRAL_FILL)
                        .attr('stroke', d => colorHexCodes[d.type])
                        .attr('stroke-width', 3);

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
    <div class="flex-1 relative">
        <div ref="graphContainer" class="w-full h-full"></div>
    </div>
</template>

<style scoped>

</style>

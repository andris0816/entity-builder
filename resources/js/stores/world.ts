import {defineStore} from "pinia";
import {WorldState} from "../types/worldState";
import {Relationship} from "../types/relationship";
import {Entity} from "../types/entity";
import {apiFetch} from "../utils/api";
import {ViewPort} from "../types/ViewPort";
import {RouteParamValue} from "vue-router";

export const useWorldStore = defineStore('world', {
    state: (): WorldState => ({
        worldId: null,
        entities: [],
        relationships: [],
        selectedEntityId: null,
        viewport: {x: 0, y: 0, zoom: 1},
        isLoading: false,
        dragInProgress: false,
    }),
    getters: {
        selectedEntity: (state): Entity | undefined => {
            return state.entities.find(e => e.id === state.selectedEntityId);
        },
        entityRelationships: (state) => (entityId: number): Relationship[] => {
            return state.relationships.filter(
                rel => rel.entityFrom === entityId || rel.entityTo === entityId
            );
        },
        simplifiedEntities: (state): { id: number, name: string }[] => {
            return state.entities.map(({ id, name }) => ({ id, name }));
        }
    },
    actions: {
        async loadWorld(worldId: string | RouteParamValue[]): Promise<void> {
            this.isLoading = true;
            try {
                this.worldId = worldId;
                const response = await apiFetch(`/worlds/${this.worldId}`);
                const data = await response.json();

                this.entities = data.data.entities;
                this.relationships = data.data.relationships;
            } catch (err) {
                console.error(err);
            } finally {
                this.isLoading = false;
            }
        },
        selectEntity(entityId: number): void {
            this.selectedEntityId = entityId;
        },
        updateViewport(viewport: Partial<ViewPort>): void {
            this.viewport = { ...this.viewport, ...viewport };
        },
        addEntity(entity: Entity): void {
            this.entities.push(entity);
        },
        addRelationship(relationship: Relationship): void {
            this.relationships.push(relationship);
        }
    },
})

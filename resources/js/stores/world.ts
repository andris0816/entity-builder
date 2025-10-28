import {defineStore} from "pinia";
import {WorldState} from "../types/worldState";
import {Entity} from "../types/entity";
import {Relationship} from "../types/relationship";
import {apiFetch} from "../utils/api";
import {ViewPort} from "../types/ViewPort";

export const useWorldStore = defineStore('world', {
    state: (): WorldState => ({
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
        }
    },
    actions: {
        async loadWorld(worldId: number): Promise<void> {
            this.isLoading = true;
            try {
                const response = await apiFetch(`/worlds/${worldId}`);
                const data = await response.json();

                this.entities = data.entities;
                this.relationships = data.relationships;
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
        }
    },
})

import {defineStore} from "pinia";
import {WorldState} from "../types/worldState";
import {Entity} from "../types/entity";
import {Relationship} from "../types/relationship";
import {apiFetch} from "../utils/api";

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

    },
})

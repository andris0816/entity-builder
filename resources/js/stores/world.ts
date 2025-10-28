import {defineStore} from "pinia";
import {WorldState} from "../types/worldState";

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

    },
    actions: {

    },
})

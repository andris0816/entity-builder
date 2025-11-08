import {defineStore} from "pinia";
import {SelectedItem, WorldState} from "../types/worldState";
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
        selectedItem: null as SelectedItem,
        viewport: {x: 0, y: 0, zoom: 1},
        isLoading: false,
        dragInProgress: false,
    }),
    getters: {
        selectedItemObject: (state): Entity | Relationship | undefined => {
            const item = state.selectedItem;
            if (!item) return undefined;

            switch (item.type) {
                case 'entity':
                    return state.entities.find(e => e.id === item.id);
                case 'relationship':
                    return state.relationships.find(r => r.id === item.id);
            }
        },
        entityRelationships: (state) => (entityId: number): Relationship[] => {
            return state.relationships.filter(
                rel => rel.source.id === entityId || rel.target.id === entityId
            );
        },
        simplifiedEntities: (state): { id: number, name: string }[] => {
            return state.entities.map(({ id, name }) => ({ id, name }));
        },
        relatedEntities: (state) => (entityId: number): { relationship: Relationship, entity?: Entity }[] => {
          return state.relationships
              .filter(rel => rel.source?.id === entityId ||
                  rel.target?.id === entityId)
              .map(rel => ({
                  relationship: rel,
                  entity: rel.source.id === entityId ? rel.target : rel.source,
              }));
        },
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
        selectItem(type: 'entity' | 'relationship', id: number): void {
            this.selectedItem = { type, id } as SelectedItem;
        },
        clearItemSelection(): void {
            this.selectedItem = null as SelectedItem;
        },
        updateViewport(viewport: Partial<ViewPort>): void {
            this.viewport = { ...this.viewport, ...viewport };
        },
        addEntity(entity: Entity): void {
            this.entities.push(entity);
        },
        addRelationship(relationship: Relationship): void {
            this.relationships.push(relationship);
        },
        removeSelectedItem(): void {
            if (this.selectedItem === null) return;
            const selectedId = this.selectedItem.id;

            const lookup: Record<'entity' | 'relationship', (id: number | string) => void> = {
                entity: (id) => {
                    const index = this.entities.findIndex((e: Entity) => e.id === id);

                    if (index === -1) return;

                    this.entities.splice(index, 1);

                    this.relationships = this.relationships.filter((rel: Relationship) =>
                        rel.target.id !== id &&
                        rel.source.id !== id
                    );
                },
                relationship: (id) => {
                    this.relationships = this.relationships.filter((rel: Relationship) =>
                        rel.id !== id
                    );
                }
            }

            lookup[this.selectedItem.type]?.(selectedId);
            this.selectedItem = null;
        },
        updateSelectedEntity(formData: Partial<Entity>): void {
            const entity = this.entities.find(e => e.id === this.selectedItemId);
            if (entity) Object.assign(entity, formData);

            for (const rel of this.relationships) {
                if (rel.source.id === this.selectedItemId) {
                    Object.assign(rel.source, formData);
                }

                if (rel.target.id === this.selectedItemId) {
                    Object.assign(rel.target, formData);
                }
            }
        }
    },
})

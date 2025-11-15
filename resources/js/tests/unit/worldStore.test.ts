import {describe, it, expect, beforeEach} from 'vitest';
import {setActivePinia, createPinia} from "pinia";
import {useWorldStore} from "../../stores/world";
import {Entity} from "../../types/entity";
import {Relationship} from "../../types/relationship";

describe('world store', () => {
    beforeEach(() => {
       setActivePinia(createPinia());
    });

    it('adds an entity', () => {
        const store = useWorldStore();
        const entity = createTestEntity();
        store.addEntity(entity);
        expect(store.entities).toContainEqual(entity);
    });

    it('selects and clears item', () => {
       const store = useWorldStore();
       const entity = createTestEntity();
       store.addEntity(entity);
       store.selectItem('entity', entity.id);
       expect(store.selectedItemObject).toEqual(entity);
       store.clearItemSelection();
       expect(store.selectedItem).toBeNull();
    });

    it("removes selected entity and it's relationships", () => {
        const store = useWorldStore();
        const entity1 = createTestEntity();
        const entity2 = createTestEntity();
        const relationship = createRelationship(entity1, entity2);

        store.entities = [entity1, entity2];
        store.relationships = [relationship];

        store.selectItem('entity', entity1.id);
        store.removeSelectedItem();
        expect(store.entities).toEqual([entity2]);
        expect(store.relationships.length).toBe(0);
    });

    it("updates the selected entity", () => {
        const store = useWorldStore();
        const entity = createTestEntity();
        store.addEntity(entity);
        store.selectItem('entity', entity.id);

        const originalRef = store.selectedItemObject;

        store.updateSelectedItem({
           name: 'Updated',
           desc: 'Updated desc',
           type: 'Event',
        });

        expect(store.selectedItemObject).toBe(originalRef);

        expect(store.selectedItemObject).toMatchObject({
            name: "Updated",
            desc: "Updated desc",
            type: "Event",
        });
    });
})

function createTestEntity(): Entity {
    return {
        id: Math.floor(Math.random() * 1000000),
        name: "Elyra",
        desc: "A mysterious wanderer.",
        type: "Character",
        createdAt: new Date(),
        updatedAt: new Date(),
    };
}

function createRelationship(entity1: Entity, entity2: Entity): Relationship {
    return {
        id: Math.floor(Math.random() * 1000000),
        source: entity2,
        target: entity1,
        type: 'Allies with',
        desc: 'These 2 know each other',
        createdAt: new Date(),
        updatedAt: new Date(),
    }
}

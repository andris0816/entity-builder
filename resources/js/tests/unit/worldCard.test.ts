import {describe, it, expect, vi} from "vitest";
import {mount} from '@vue/test-utils';
import WorldCard from "../../components/Dashboard/WorldCard.vue";
import {World} from "../../types/world";

const testWorld: World = {
    id: 1,
    name: 'Narnia',
    desc: 'A world',
    createdAt: new Date(),
    updatedAt: new Date(),
    entitiesCount: 4,
}

describe('WorldCard', () => {
    it('renders a world name and entity count', () => {
        const wrapper = mount(WorldCard, {
           props: { world: testWorld }
        });

        expect(wrapper.text()).toContain('Narnia');
        expect(wrapper.text()).toContain(4);
   });

    it('emits a click event with the world payload', async () => {
        const wrapper = mount(WorldCard, {
            props: { world: testWorld }
        });

        await wrapper.trigger('click');

        const events = wrapper.emitted().click;
        expect(events).toBeTruthy();
        expect(events[0][0]).toBeInstanceOf(MouseEvent);
    });
});

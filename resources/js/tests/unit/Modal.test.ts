import {render, fireEvent} from "@testing-library/vue";
import Modal from "../../components/Modal.vue";
import {expect, it} from "vitest";

it('emit close when cancel button is clicked', async () => {
   const { getByText, emitted } = render(Modal, {
       props: { show: true },
   });

   await fireEvent.click(getByText('Cancel'));
   expect(emitted().close).toBeTruthy();
});

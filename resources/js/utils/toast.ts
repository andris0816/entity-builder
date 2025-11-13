import {toast as vToast} from "vue3-toastify";

export const toast = {
    success(message: string) {
        vToast.success(message, {
            theme: 'colored'
        });
    },

    error(message: string) {
        vToast.error(message, {
            theme: 'colored'
        });
    },

    info(message: string) {
        vToast.info(message, {
            theme: 'colored'
        });
    }
}

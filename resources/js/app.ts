import './bootstrap';
import {createApp} from "vue";
import '../css/app.css';

import App from "./App.vue";
import {router} from "./router";
import {createPinia} from "pinia";
import Vue3Toastify, { type ToastContainerOptions } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const pinia = createPinia();
createApp(App).use(
    Vue3Toastify,
    {
        autoClose: 3000,
        position: "top-right",
    } as ToastContainerOptions,
).use(router).use(pinia).mount("#app");

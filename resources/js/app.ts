import './bootstrap';
import {createApp} from "vue";
import '../css/app.css';

import App from "./App.vue";
import {router} from "./router";
import {createPinia} from "pinia";

const pinia = createPinia();
createApp(App).use(router).use(pinia).mount("#app");

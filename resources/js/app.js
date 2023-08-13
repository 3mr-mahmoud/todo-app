import './bootstrap';
import Vue3Toastify, { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';


import { createApp } from 'vue'

import App from './components/App.vue'

createApp(App)
    .use(Vue3Toastify, {
        position: toast.POSITION.BOTTOM_RIGHT,
        autoClose: 1500,
    }).mount("#app")
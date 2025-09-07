import { createApp } from 'vue'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.min.js'
import 'bootstrap-icons/font/bootstrap-icons.min.css'
import 'vue-loading-overlay/dist/css/index.css'
import "vue-toastification/dist/index.css"
import './style.css'
import Toast from "vue-toastification"
import { createPinia } from 'pinia'
import App from './App.vue'
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'
import router from './router'

const pinia = createPinia()

pinia.use(piniaPluginPersistedstate)

createApp(App)
    .use(router)
    .use(Toast)
    .use(pinia)
    .mount('#app')
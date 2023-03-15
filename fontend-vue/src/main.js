import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import Shop from '@/components/Layout/Shop/ShopLayout.vue'
// import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import './assets/main.css'
import './assets/app.scss'

const app = createApp(App)

app.use(router)
app.component('shop-layout', Shop)
// app.use(BootstrapVue)
// app.use(IconsPlugin)

app.mount('#app')
import "bootstrap/dist/js/bootstrap.js";
import { createApp } from 'vue'

import App from './App.vue'
import router from './router'
import store from './stores/store'
import Vuex from 'vuex';

import ShopLayout from '@/components/Layout/Shop/ShopLayout.vue'
import AdminLayout from '@/components/Layout/Admin/AdminLayout.vue'

import './assets/app.scss'

const app = createApp(App)

app.use(router)
app.use(Vuex)
app.use(store)

app.component('shop-layout', ShopLayout)
app.component('admin-layout', AdminLayout)

app.mount('#app')

import "bootstrap/dist/js/bootstrap.js";
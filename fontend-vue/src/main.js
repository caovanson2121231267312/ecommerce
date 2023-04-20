import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './stores/store'
import { checkResponseCode } from './utils'
import Vuex from 'vuex'
import { vue3Debounce } from 'vue-debounce'
import VTooltip from 'v-tooltip'
import VueSweetalert2 from 'vue-sweetalert2'
import PrimeVue from 'primevue/config'

import 'sweetalert2/dist/sweetalert2.min.css'
import ShopLayout from '@/components/Layout/Shop/ShopLayout.vue'
import AdminLayout from '@/components/Layout/Admin/AdminLayout.vue'
import NoneLayout from '@/components/Layout/Others/NoneLayout.vue'

import '@/assets/admin/css/bootstrap.css'
import '@/assets/admin/css/index.css'
import '@/assets/admin/css/base.scss'
import './assets/app.scss'

const app = createApp(App)

app.use(VueSweetalert2)
app.use(router)
app.use(Vuex)
app.use(store)
app.use(vue3Debounce)
app.use(VTooltip)
app.use(PrimeVue)
// app.component('ckeditor', require('./components/Ckeditor.vue').default)
import CKEditor from '@ckeditor/ckeditor5-vue'

app.use(CKEditor)

app.component('shop-layout', ShopLayout)
app.component('none-layout', NoneLayout)
app.component('admin-layout', AdminLayout)

app.directive('debounce', vue3Debounce({ lock: true })).mount('#app')

// import 'bootstrap/dist/js/bootstrap.js'
import '@/assets/admin/js/index.js'
import '@/assets/admin/js/app.js'

app.mixin({
    methods: {
        $checkResponseCode: checkResponseCode
    }
})

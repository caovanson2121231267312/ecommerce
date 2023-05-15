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
import Echo from 'laravel-echo'
import Pusher from 'pusher-js'

import 'sweetalert2/dist/sweetalert2.min.css'
import ShopLayout from '@/components/Layout/Shop/ShopLayout.vue'
import AdminLayout from '@/components/Layout/Admin/AdminLayout.vue'
import NoneLayout from '@/components/Layout/Others/NoneLayout.vue'

import '@/assets/admin/css/bootstrap.css'
import '@/assets/admin/css/index.css'
import '@/assets/admin/css/base.scss'
import './assets/app.scss'

const app = createApp(App)

window.Pusher = Pusher

if (JSON.parse(localStorage.getItem('auth'))) {
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: 'local',
        wsHost: '127.0.0.1',
        wsPort: 6001,
        wssPort: 6001,
        cluster: 'mt1',
        forceTLS: false,
        disableStats: true,
        encrypted: true,
        enabledTransports: ['ws', 'wss'],
        authEndpoint: 'http://127.0.0.1:8000/api/broadcasting/auth',
        auth: {
            headers: {
                Authorization: 'Bearer ' + JSON.parse(localStorage.getItem('auth')).access_token
            }
        }
    })
}
app.mixin({
    methods: {
        $checkResponseCode: checkResponseCode
    }
})

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

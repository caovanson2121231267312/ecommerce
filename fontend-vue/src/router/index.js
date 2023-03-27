import { createRouter, createWebHistory } from 'vue-router'
import NotFound from '../views/Error/404.vue'
import { alert, notify } from '../config'

const router = createRouter({
    history: createWebHistory(),
    // history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            name: 'home',
            meta: {
                layout: 'shop',
                auth: false
            },
            component: () => import('../views/Shop/HomeView.vue')
        },
        {
            path: '/login',
            name: 'login',
            meta: {
                layout: 'none',
                auth: false
            },
            component: () => import('../views/Shop/LoginView.vue')
        },
        {
            path: '/signup',
            name: 'signup',
            meta: {
                layout: 'none',
                auth: false
            },
            component: () => import('../views/Shop/RegisterView.vue')
        },
        {
            path: '/cart',
            name: 'cart',
            meta: {
                layout: 'shop',
                auth: false
            },
            component: () => import('../views/Shop/CartView.vue')
        },
        {
            path: '/admin',
            name: 'admin',
            meta: {
                layout: 'admin',
                auth: true
            },
            component: () => import('../views/AboutView.vue')
        },
        {
            path: '/admin/categories',
            name: 'admin.categories',
            meta: {
                layout: 'admin',
                auth: true
            },
            component: () => import('../views/Admin/Category/Index.vue')
        },
        {
            path: '/:slug',
            name: 'product',
            // props: true,
            meta: {
                layout: 'shop',
                auth: false
            },
            component: () => import('../views/Shop/ProductView.vue')
        },
        {
            path: '/:catchAll(.*)',
            name: 'NotFound',
            meta: {
                layout: 'shop',
                auth: false
            },
            component: NotFound
        }
    ]
})

router.beforeEach((to, from, next) => {
    if (to.matched.some((record) => record.meta.auth)) {
        if (localStorage.getItem('auth')) {
            next()
        } else {
            alert('warning', '', 'Bạn cần đăng nhập để truy cập vào trang này')
            next('/')
        }
    } else {
        next()
    }
})

router.beforeEach((to, from, next) => {
    if (to.matched.length === 0) {
        next('/not-found')
    } else {
        next()
    }
})

export default router

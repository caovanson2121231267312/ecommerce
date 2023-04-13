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
            name: 'admin-categories',
            meta: {
                layout: 'admin',
                auth: true
            },
            component: () => import('../views/Admin/Category/Index.vue')
        },
        {
            path: '/admin/brands',
            name: 'admin-brands',
            meta: {
                layout: 'admin',
                auth: true
            },
            component: () => import('../views/Admin/Brand/Index.vue')
        },
        {
            path: '/admin/tags',
            name: 'admin-tags',
            meta: {
                layout: 'admin',
                auth: true
            },
            component: () => import('../views/Admin/Tag/Index.vue')
        },
        {
            path: '/admin/products',
            name: 'admin-products',
            meta: {
                layout: 'admin',
                auth: true
            },
            component: () => import('../views/Admin/Product/Index.vue')
        },
        {
            path: '/admin/permissions',
            name: 'admin-permissions',
            meta: {
                layout: 'admin',
                auth: true
            },
            component: () => import('../views/Admin/Permission/Index.vue')
        },
        {
            path: '/admin/roles',
            name: 'admin-roles',
            meta: {
                layout: 'admin',
                auth: true
            },
            component: () => import('../views/Admin/Role/Index.vue')
        },
        {
            path: '/admin/roles/create',
            name: 'admin-roles-create',
            meta: {
                layout: 'admin',
                auth: true
            },
            component: () => import('../views/Admin/Role/Create.vue')
        },
        {
            path: '/admin/roles/edit/:id',
            name: 'admin-roles-edit',
            meta: {
                layout: 'admin',
                auth: true
            },
            component: () => import('../views/Admin/Role/Edit.vue')
        },
        {
            path: '/admin/users',
            name: 'admin-users',
            meta: {
                layout: 'admin',
                auth: true
            },
            component: () => import('../views/Admin/User/Index.vue')
        },
        {
            path: '/admin/users/create',
            name: 'admin-users-create',
            meta: {
                layout: 'admin',
                auth: true
            },
            component: () => import('../views/Admin/User/Create.vue')
        },
        {
            path: '/admin/users/edit/{slug}',
            name: 'admin-users-edit',
            meta: {
                layout: 'admin',
                auth: true
            },
            component: () => import('../views/Admin/User/Edit.vue')
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

import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import NotFound from '../views/Error/404.vue';

const router = createRouter({
  history: createWebHistory(),
  // history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      meta: {
        layout: 'shop'
      },
      component: () => import('../views/Shop/HomeView.vue')
    },
    {
      path: '/login',
      name: 'login',
      meta: {
        layout: 'shop'
      },
      component: () => import('../views/Shop/HomeView.vue')
    },
    {
      path: '/signup',
      name: 'signup',
      meta: {
        layout: 'shop'
      },
      component: () => import('../views/Shop/HomeView.vue')
    },
    {
      path: '/cart',
      name: 'cart',
      meta: {
        layout: 'shop'
      },
      component: () => import('../views/Shop/CartView.vue')
    },
    {
      path: '/about',
      name: 'about',
      meta: {
        layout: 'admin'
      },
      component: () => import('../views/AboutView.vue')
    },
    {
      path: '/:slug',
      name: 'product',
      // props: true,
      meta: {
        layout: 'shop'
      },
      component: () => import('../views/Shop/ProductView.vue')
    },
    { 
      path: "/:catchAll(.*)",
      name: 'NotFound',
      meta: {
        layout: 'shop'
      },
      component: NotFound
    }
  ]
})

router.beforeEach((to, from, next) => {
  if (to.matched.length === 0) {
    next('/not-found')
  } else {
    next()
  }
})


export default router

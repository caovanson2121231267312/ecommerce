import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
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
      component: () => import('../views/Shop/HomeView.vue')
    },
    {
      path: '/about',
      name: 'about',
      meta: {
        layout: 'admin'
      },
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/AboutView.vue')
    }
  ]
})

export default router

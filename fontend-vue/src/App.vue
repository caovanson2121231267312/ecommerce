<script setup>
import { RouterView } from 'vue-router'
import 'mosha-vue-toastify/dist/style.css'
import HelloWorld from './components/HelloWorld.vue'
</script>

<script>
import { alert } from "./config"

const defaultLayout = 'shop'

export default {
  computed: {
    layout() {
      return (this.$route.meta.layout || defaultLayout) + '-layout'
    },
  },
}
</script>

<template>
  <component class="body" :is="layout">
    <RouterView />
  </component>
</template>



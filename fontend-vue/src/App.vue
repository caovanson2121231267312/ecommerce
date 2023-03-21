<script setup>
import { RouterView } from 'vue-router'
import 'mosha-vue-toastify/dist/style.css'
import HelloWorld from './components/HelloWorld.vue'
</script>

<script>
const defaultLayout = 'shop'

export default {
  computed: {
    layout() {
      return (this.$route.meta.layout || defaultLayout) + '-layout'
    }
  },
  created() {
  },
  updated() {
  }
}
</script>

<template>
  <!-- <header>
          <img alt="Vue logo" class="logo" src="@/assets/logo.svg" width="125" height="125" />

          <div class="wrapper">
            <HelloWorld msg="You did it!" />

            <nav>
              <RouterLink to="/">Home</RouterLink>
              <RouterLink to="/about">About</RouterLink>
            </nav>
          </div>
        </header> -->

  <component class="body" :is="layout">
    <RouterView />
  </component>
</template>



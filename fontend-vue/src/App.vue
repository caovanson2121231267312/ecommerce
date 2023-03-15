<script setup>
import { RouterView } from 'vue-router'
import HelloWorld from './components/HelloWorld.vue'
</script>

<script>
const defaultLayout = 'shop'

export default {
  computed: {
    layout () {
      const a = (this.$route.meta.layout || defaultLayout) + '-layout'
      console.log(a)
      return a
    }
  },
  created () {
    console.log(this.$route, this.$route.meta.layout)
  },
  updated () {
    console.log(this.$route, this.$route.meta.layout)
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



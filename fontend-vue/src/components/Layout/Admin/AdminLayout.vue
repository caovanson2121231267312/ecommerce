<script>
import Header from './Header.vue';

export default {
  components: {
    Header,
  }
}
</script>

<template>
    <div>
        <Header />
        <slot />
    </div>
</template>
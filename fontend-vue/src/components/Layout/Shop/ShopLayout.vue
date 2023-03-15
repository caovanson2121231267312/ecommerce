<script>
import Header from './Header.vue';
import Footer from './Footer.vue';

export default {
  components: {
    Header,
    Footer,
  }
}
</script>

<template>
    <div>
        <Header />

        <slot />

        <Footer />
    </div>
</template>
<script>
import Header from './Header.vue';
import NavBar from './Navbar.vue';
import Footer from './Footer.vue';

export default {
  components: {
    Header,
    NavBar,
    Footer,
  },
  computed: {
    auth() {
      return this.$store.getters.auth
    }
  },
  mounted() {
    console.log(this.auth)
    if (!this.auth) {
      this.$router.push('/login')
    }
  }
}
</script>

<template>
  <div id="layout-wrapper">

    <Header v-if="auth" :auth="auth" />

    <NavBar v-if="auth" />

    <div class="content-page">
      <div class="content">
        <div class="container-fluid">
          <slot />
        </div>
      </div>

      <Footer v-if="auth" />

    </div>

  </div>
</template>

<style lang="css" ></style>

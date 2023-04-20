<script>
import Header from './Header.vue';
import NavBar from './Navbar.vue';
import Footer from './Footer.vue';
import api from "../../../stores/axios"

export default {
  components: {
    Header,
    NavBar,
    Footer,
  },
  data() {
    return {
      ready: false,
    }
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
    } else {
      try {
        const data = api.get('api/auth/user-profile', {
          'Content-Type': 'application/json',
          'Authorization': 'Bearer ' + JSON.parse(localStorage.getItem('auth')).access_token
        }, this)
        this.ready = true
      } catch (e) {
        this.ready = false
        this.$router.push('/login')
      }
    }
  }
}
</script>

<template>
  <div id="layout-wrapper" v-if="ready">

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

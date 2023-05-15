<script>
import Header from './Header.vue';
import Footer from './Footer.vue';
import ChatForm from '../../Chat/ChatForm.vue';

export default {
  components: {
    Header,
    Footer,
    ChatForm
  }
}
</script>

<template>
  <div>
    <Header />

    <slot />

    <ChatForm />

    <Footer />
  </div>
</template>
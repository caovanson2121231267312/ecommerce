
<template >
    <section class="mt-5">
        <h1 class="h1 text-center">cao vawn sown</h1>
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 col-xxl-2" v-for="(product, index) in products"
                    v-bind:key="index">
                    <Item :product="product" />
                </div>
            </div>
        </div>
    </section>
</template>



<script>
import Item from "./Item.vue";

export default {
    mounted() {
        this.$store.dispatch('getProducts')
    },
    computed: {
        products() {
            return this.$store.getters.products
        },
    },
    components: {
        Item,
    },
}

</script>
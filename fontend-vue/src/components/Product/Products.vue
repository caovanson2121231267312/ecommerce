
<template >
    <section class="mt-5">
        <div class="container">
            <div class="mb-3 d-flex justify-content-between">
                <h2 class="h2 m-0">cao vawn sown</h2>
                <div class="d-flex justify-content-around">
                    <a class="d-inline-block btn btn-light">
                        123
                    </a>
                    <a class="d-inline-block btn btn-light">
                        123
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 col-xxl-2 mb-3" v-for="(product, index) in products"
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

<style lang="scss" scoped>
$grid-columns: 10;

@media (min-width: 1200px) {
    .col-xl-2 {
        -webkit-box-flex: 0;
        -ms-flex: 0 0 auto;
        flex: 0 0 auto;
        width: 20%;
    }
}
</style>
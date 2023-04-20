<template>
    <Banner />

    <HotSale />
    <Products />

    <section class="mt-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <img class="img-fluid" src="@/assets/images/banners/seo.jpg" alt="cao van son" />
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import Products from "../../components/Product/Products.vue";
import HotSale from "../../components/Product/HotSale.vue";
import Banner from "../../components/Banner/Main.vue";

export default {
    components: {
        Products,
        Banner,
        HotSale,
    },
    setup() {
        // const store = useStore()
    },
    methods: {

    },
    computed: {

    }
}
</script>

<style>
.btn-group {
    float: right;
}
</style>
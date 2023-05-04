<template>
    <Banner />

    <HotSale />

    <section class="mt-2" v-for="(item, index) in category" v-bind:key="index">
        <Products :item="item" />
    </section>

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
    data() {
        return {
            category: [
                { name: "Điện thoại", slug: "dien-thoai", limit: 10, page: 1 },
                { name: "Laptop", slug: "laptop", limit: 10, page: 1 },
                // { name: "PC", slug: "pc", limit: 10, page: 1 },
                { name: "Màn hình", slug: "man-hinh", limit: 10, page: 1 },
                { name: "Tablet", slug: "tablet", limit: 10, page: 1 },
                { name: "Đồng hồ", slug: "dong-ho", limit: 10, page: 1 },
                // { name: "Âm thanh", slug: "am-thanh", limit: 10, page: 1 },
                { name: "Smart Home", slug: "smart-home", limit: 10, page: 1 },
                { name: "Smart TV", slug: "smart-tv", limit: 10, page: 1 },
                { name: "Phụ kiện", slug: "phu-kien", limit: 10, page: 1 },
            ],
        }
    },
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
<template>
    <Breadcrumb :items="breadcrumb_arr()" />
    <div v-if="isLoading">Loading...</div>
    <div v-else>
        <ProductDetail :product="product" />
    </div>
    <Products />
    <div>
        <h1 :class="slug">{{ product.category?.name }}</h1>
    </div>
</template>

<script>
import Products from "../../components/Product/Products.vue";
import ProductDetail from "../../components/Product/ProductDetail.vue";
import Breadcrumb from "../../components/Breadcrumb.vue";

export default {
    data() {
        return {
            slug: '',
        }
    },
    components: {
        Products,
        ProductDetail,
        Breadcrumb,
    },
    methods: {
        breadcrumb_arr() {
            var arr = [];
            arr.push({
                'name': this.product.category?.name,
                'slug': this.product.category?.slug
            }, {
                'name': this.product?.name,
                'slug': this.product?.slug
            });
            return arr;
        },
    },
    computed: {
        product() {
            return this.$store.getters.product
        },
        isLoading() {
            return this.$store.getters.isLoading
        }
    },
    mounted() {
        const loadData = async () => {
            console.log(123)
            await this.$store.dispatch('isLoading', true)
            await this.$store.dispatch('productDetail', this.slug)
            await this.$store.dispatch('isLoading', false)
        }
        loadData();
    },
    beforeRouteEnter(to, _from, next) {
        next((vm) => {
            vm.slug = to.params.slug
        });
    },
    beforeRouteUpdate(to, _from, next) {
        this.slug = to.params.slug;
        this.$store.dispatch('productDetail', this.slug)
        next();
    },
    watch: {
        slug() {
            console.log(this.slug)
        }
    }
}
</script>

<style>
.btn-group {
    float: right;
}
</style>
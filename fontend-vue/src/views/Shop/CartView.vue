<template>
    <Breadcrumb :items="breadcrumb_arr()" />
    <div v-if="isLoading">Loading...</div>
    <div v-else>
        <template v-if="product">
            <Cart :products="getProduct" :carts="productInCart" />
        </template>
    </div>
</template>

<script>
import Products from "../../components/Product/Products.vue";
import ProductDetail from "../../components/Product/ProductDetail.vue";
import Cart from "../../components/Cart/Cart.vue";
import Breadcrumb from "../../components/Breadcrumb.vue";
import product from "../../stores/products/ListProducts";
import { getProductInCart } from "../../config"

export default {
    data() {
        return {
            product: null,
        }
    },
    components: {
        Cart,
        Breadcrumb,
    },
    methods: {
        breadcrumb_arr() {
            var arr = [];
            arr.push({
                'name': 'Giỏ hàng',
                'slug': "/cart"
            });
            return arr;
        },
    },
    computed: {
        isLoading() {
            return this.$store.getters.isLoading
        },
        cart() {
            return this.$store.getters.cart
        },
        productInCart() {
            return getProductInCart(this.cart);
        },
        getProduct() {
            return this.product
        }
    },
    mounted() {
        const loadData = async () => {
            await this.$store.dispatch('isLoading', true)
            await product.post("api/carts", { "cart": this.productInCart }, {
                'Content-Type': 'multipart/form-data'
            }).then(response => {
                console.log(response)
                this.product = response.data.data
            });
            console.log(this.product)
            await this.$store.dispatch('isLoading', false)
        }
        loadData();
    },
    // beforeRouteEnter(to, _from, next) {
    //     next((vm) => {
    //         vm.slug = to.params.slug
    //     });
    // },
    // beforeRouteUpdate(to, _from, next) {
    //     this.slug = to.params.slug;
    //     this.$store.dispatch('productDetail', this.slug)
    //     next();
    // },
    // watch: {
    //     slug() {
    //         console.log(this.slug)
    //     }
    // }
}
</script>

<style>
.btn-group {
    float: right;
}
</style>
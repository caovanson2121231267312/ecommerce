<template v-if="products">
    <div class="container">
        <div class="cart">
            <div class="position-relative">
                <span class="fw-bold">
                    <i class="fas fa-chevron-left"></i> Quay lại
                </span>
                <span class="position-absolute top-50 start-50 translate-middle color-default fw-bold">
                    Giỏ Hàng
                </span>
            </div>
            <div class="mt-3" v-for="(product, index) in items" v-bind:key="index">
                <div class="card box-card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">
                                <RouterLink class="w-100 border-2 rounded-1" :to="product.slug ?? '/cart'">
                                    <img class="img-fluid" :src="firstImage(product.images)" />
                                </RouterLink>
                            </div>
                            <div class="col-9">
                                <h4 class="h6 fw-bold">
                                    {{ product.name }}
                                    <span class="float-end cancel-cart" @click="removeCart(product.id)">
                                        <i class="fas fa-times"></i>
                                    </span>
                                </h4>
                                <p>
                                    <span class="product-price">
                                        {{ formatCurrency(saleProduct(product.price, product.sale)) }} VNĐ
                                    </span>
                                    <span class="ms-3 text-muted text-decoration-line-through">
                                        {{ formatCurrency(saleProduct(product.price, product.sale)) }} VNĐ
                                    </span>
                                </p>
                                <p class="margin-10">
                                    <button class="btn" @click="minus(product.id)"> - </button>
                                    <input :value="product.count" type="text" disabled />
                                    <button class="btn" @click="plus(product.id)"> + </button>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card box-card mt-5 mb-5">
                <div class="card-body">
                    <div>
                        <h5 class="h6 fw-bold">
                            Tổng tiền: <span class="product-price float-end">{{ formatCurrency(countMoney) }}</span>
                        </h5>
                    </div>
                    <div class="w-100">
                        <RouterLink class="w-100 border-2 rounded-1 btn-cart" :to="'/cart'">
                            Tiến hành đặt hàng
                        </RouterLink>
                        <RouterLink class="w-100 border-2 rounded-1 btn-cart-add-more" to="/">
                            Chọn thêm sản phẩm
                        </RouterLink>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    products: {
        type: Object,
        required: true,
    },
    carts: {
        type: Object,
        required: true,
    },
});
</script>

<script>
import { mergeProductInCart, firstImage } from "../../config"
import { formatCurrency, saleProduct } from "../../config"
import {
    RouterLink
} from 'vue-router'

export default {
    computed: {
        items() {
            return mergeProductInCart(this.carts, this.products);
        },
        countMoney() {
            let count = 0;
            console.log(this.items)
            this.items.forEach(function (value) {
                console.log(value);
                count += saleProduct(value.price, value.sale) * value.count
            });
            return count
        },
    },
    mounted() {
    },
    methods: {
        plus(id) {
            const product = {
                "id": id,
                "count": 1,
                "created_at": new Date().toLocaleString()
            }
            this.$store.dispatch('addToCart', product)
        },
        minus(id) {
            this.$store.dispatch('minusToCart', id)
        },
        removeCart(id) {
            this.$store.dispatch('removeCart', id)
        }

    }
}
</script>

<style lang="scss">
.cart {
    width: 550px;
    margin: 0 auto;
}

.cancel-cart {
    transition: .3s;
}

.cancel-cart:hover {
    color: rgb(218, 57, 57);
    transform: scale(1.3);
}
</style>
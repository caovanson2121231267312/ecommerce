<script setup>
defineProps({
    product: {
        type: Object,
        required: true,
    },
});
</script>

<script>
import {
    RouterLink
} from 'vue-router'
import { domain, formatCurrency, saleProduct } from "../../config"
import Stars from "@/components/Rate/Index.vue";

export default {
    methods: {
    },
    components: {
        Stars,
    },
    computed: {
        firstImage() {
            if (this.product.images.length > 0) {
                const images = JSON.parse(this.product.images)
                return domain + images[0].image;
            } else {
                return null;
            }
        },

    },
}
</script>

<template>
    <div class="card">
        <div class="card-body">
            <div class="image">
                <RouterLink class="w-full" aria-current="page" :to="product.slug">
                    <img class="img-fluid h-100 w-100 object-fit-cover" :src="firstImage" />
                </RouterLink>
            </div>
            <h4 class="h5 mt-2 text-dark text-product">
                {{ product.name }}
            </h4>
            <div class="d-flex justify-content-between">
                <span class="fw-bold price">
                    {{ formatCurrency(saleProduct(product.price, product.sale)) }} đ
                </span>
                <span class="text-muted text-decoration-line-through fs-6">
                    {{ formatCurrency(product.price) }}
                </span>
            </div>
            <div class="product__price--percent">
                <p class="product__price--percent-detail">
                    Giảm {{ product.sale }}%
                </p>
            </div>
            <div class="sticker sticker-left">
                <span><img src="@/assets/images/icons/gia-soc.png" title="Sản phẩm giá sốc" /></span>
            </div>
            <!-- {{ firstImage() }} -->
            <div>
                <Stars :rates_count="product.rates_count" :rate="product.avg_rate" />
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
.price {
    color: #d70018 !important;
}

.object-fit-cover {
    object-fit: scale-down;
}

.image {
    height: 145px;
}

.card {
    --bs-card-spacer-y: 0.6rem;
    --bs-card-spacer-x: 0.6rem;
}

.text-product {
    // white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    line-height: 21px;
    height: 42px;
    display: -webkit-box;
}
</style>
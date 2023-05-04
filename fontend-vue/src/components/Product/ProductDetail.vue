<template>
    <div class="container">

        <div class="card">
            <div class="card-body">
                <h1 class="h2">{{ product.name }}</h1>
                <div class="row">
                    <div class="col-12 col-sm-12 col-md- col-lg-12 col-xl-9 col-xxl-9">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5 col-xxl-5">
                                <SliderImages :images="product.images" :name="product.name" />
                            </div>
                            <div class="col-12 col-sm-12 col-md-7 col-lg-7 col-xl-7 col-xxl-7">
                                <h2 class="h3 product-price">
                                    {{ formatCurrency(saleProduct(product.price, product.sale)) }} đ
                                </h2>
                                <span class="ms-3 text-muted text-decoration-line-through">
                                    {{ formatCurrency(product.price) }} đ
                                </span>

                                <div>
                                    <div>
                                        <p class="btn btn-success w-100">
                                            <i class="fas fa-truck-moving"></i> Miễn phí vận chuyển toàn quốc
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-2">
                                    <div class="row">
                                        <h6 class="h6 fw-bold">Lựa chọn cấu hình</h6>
                                        <div class="d-flex">
                                            <div class="card tags-product active">
                                                <div class="card-body">
                                                    <input class="" type="checkbox" value="" />
                                                    <span>
                                                        red
                                                    </span>
                                                    <span class="product-price d-block m-0">
                                                        {{ formatCurrency(saleProduct(product.price, product.sale)) }} đ
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="card tags-product">
                                                <div class="card-body">
                                                    <input class="" type="checkbox" value="" />
                                                    <span>
                                                        Blue
                                                    </span>
                                                    <span class="product-price d-block m-0">
                                                        {{ formatCurrency(saleProduct(product.price, product.sale)) }} đ
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-2">
                                    <div>
                                        <h6 class="h6 fw-bold">Khuyến mãi</h6>
                                        <div>
                                            <ul>
                                                <li>
                                                    <div>
                                                        <span class="bg-yellow">KM1</span>
                                                        <span class="d-block">
                                                            Mở thẻ TPbank Evo, nhận giảm giá còn từ 26.390.000đ
                                                        </span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div>
                                                        <span class="bg-yellow">KM2</span>
                                                        <span class="d-block">
                                                            Thu cũ đổi mới giảm tới 1.000.000đ
                                                        </span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-2">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md- col-lg-12 col-xl-4 col-xxl-4">
                                            <RouterLink class="w-100 btn btn-buy c-while" :to="product.slug ?? '/cart'">
                                                <div class=" fw-bold">Mua ngay
                                                </div>
                                                <div class="fs-7">Giao hàng tận nơi</div>
                                            </RouterLink>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md- col-lg-12 col-xl-4 col-xxl-4">
                                            <RouterLink class="w-100 btn btn-installment c-while"
                                                :to="product.slug ?? '/cart'">
                                                <div class="fw-bold">Trả góp</div>
                                                <div class="fs-7">Lãi súât 0%</div>
                                            </RouterLink>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md- col-lg-12 col-xl-4 col-xxl-4">
                                            <div class="w-100 btn c-while btn-cart" @click="addToCart(product.id, 1)">
                                                <div class="fw-bold">
                                                    <i class="fas fa-cart-plus"></i>
                                                </div>
                                                <div class="fs-7">Thêm vào giỏ</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md- col-lg-12 col-xl-3 col-xxl-3">
                        123
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-9 col-xl-9 col-xxl-9">
                <div class="card">
                    <div class="card-body">
                        <h1 class="text-center text-dark">
                            {{ product.name }}
                        </h1>
                        <div class="content-page-shop pt-3" :class="{ 'show-all': showAll }"
                            v-bind:innerHTML="product.content">

                        </div>
                        <button class="btn btn-primary toggle-button" @click="toggleShowAll">
                            {{ showAll ? 'Thu lại' : 'Xem thêm' }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 col-xxl-3">
                <div class="card">
                    <div class="card-body">
                        <h4 class="text-dark">
                            Thông số kỹ thuật {{ product.name }}
                        </h4>
                        <div>
                            <div class="w-100">
                                <img class="img-fluid h-100 w-100 object-fit-cover" :src="firstImage + '#'" />
                            </div>
                            <div class="d-flex justify-content-center align-item-center pe-auto" data-bs-toggle="modal"
                                data-bs-target="#bs-config">
                                <div class="btn-config mb-3">
                                    <span class="fs-3 config me-2">
                                        <i class="fas fa-cog"></i>
                                    </span>
                                    <strong class="text-dark-1 text-config">Cấu hình chi tiết</strong>
                                </div>
                            </div>
                            <div>
                                <div v-for="(item, index) in product.details" v-bind:key="index">
                                    <strong class="text-dark">
                                        {{ item.name.replace(/\:/g, "") }}:
                                    </strong>
                                    <span>
                                        {{ item.detail }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="bs-config" tabindex="-1" aria-labelledby="bs-config" aria-modal="true"
                    role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header text-bg-success border-0">
                                <h4 class="modal-title text-light" id="myLargeModalLabel">Cấu hình chi tiết</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div>
                                    <table class="table table-bordered table-hover table-striped">
                                        <tr v-for="(item, index) in product.details" v-bind:key="index">
                                            <td class="text-dark">
                                                <span class="fw-bold text-dark-1">
                                                    {{ item.name.replace(/\:/g, "") }}:
                                                </span>
                                            </td>
                                            <td>
                                                <span class="fw-bold text-dark-1">
                                                    {{ item.detail.replace(/\:/g, "") }}
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</template>

<script setup>
defineProps({
    product: {
        type: Object,
        required: true,
    },
    rates: {
        type: Object,
    }
});
</script>

<script>
import { domain, formatCurrency, saleProduct } from "../../config"
import { createToast } from 'mosha-vue-toastify';
import SliderImages from "./SliderImages.vue";
import {
    RouterLink
} from 'vue-router'

export default {
    data() {
        return {
            showAll: false,

        }
    },
    mounted() {
        // console.log(this.product)
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
    methods: {
        toggleShowAll() {
            this.showAll = !this.showAll;

            if (this.showAll) {
                this.contentHeight = this.$refs.content.clientHeight;
            } else {
                this.contentHeight = 0;
            }
        },
        addToCart(id_product, count) {
            const product = {
                "id": id_product,
                "count": count,
                "created_at": new Date().toLocaleString()
            }
            try {
                this.$store.dispatch('addToCart', product)
            } catch (e) {
                createToast('Đã có lỗi, vui lòng tải lại trang', {
                    type: 'danger',
                    transition: 'zoom',
                    showIcon: 'true',
                    hideProgressBar: 'false',
                    position: 'top-center',
                })
            }
        }
    }
}
</script>

<style scoped lang="scss">
.fs-7 {
    font-size: 12px;
    margin: 0;
    padding: 0;
}

.btn-cart {
    background: transparent linear-gradient(180deg, #ff990e 0%, #ff6801 100%) 0% 0% no-repeat padding-box;
    box-shadow: 0 4px 6px #00000029;
    border-radius: 3px;
}

.btn-installment {
    background: transparent linear-gradient(180deg, #02c9a8 0%, #03a990 100%) 0% 0% no-repeat padding-box;
    box-shadow: 0 4px 6px #00000029;
    border-radius: 3px;
}

.btn-buy {
    background: transparent linear-gradient(180deg, #fd475a 0%, #bf1e2d 100%) 0% 0% no-repeat padding-box;
    box-shadow: 0 4px 6px #00000029;
    border-radius: 3px;
}

ul {
    margin: 0;
    padding: 0;

    li {
        list-style: none;
    }
}

.bg-yellow {
    display: inline-block;
    background: #f7941e 0% 0% no-repeat padding-box;
    box-shadow: 0 4px 6px #00000029;
    border-radius: 3px;
    color: #fff;
    font-size: 11px;
    padding: 2px 5px;
}

.tags-product {
    margin-right: 10px;
    cursor: pointer;
    transition: .3s;
}

.tags-product:hover {
    border: 1px solid #0def86;
}

.tags-product.active {
    border: 1px solid #d70018;
}
</style>
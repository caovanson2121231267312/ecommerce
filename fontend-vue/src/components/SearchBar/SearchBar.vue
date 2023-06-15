<template>
    <div class="app-search dropdown d-none d-lg-block">
        <form autocomplete="off">
            <div class="input-group">
                <input v-model="keywords" type="search" class="form-control dropdown-toggle" placeholder="Search..."
                    id="top-search">
                <button class="input-group-text btn btn-primary" type="button">
                    Search
                </button>
            </div>
        </form>
        <div class="dropdown-menu dropdown-menu-animated dropdown-lg" id="search-dropdown"><!-- item-->
            <div class="dropdown-header noti-title">
                <h5 v-if="products" class="text-overflow mb-2">Found <span class="text-danger"> {{ products.length }}</span>
                    results</h5>
                <h5 v-else class="text-overflow mb-2">Nhập tên sản phẩm tìm kiếm</h5>
            </div>

            <div class="notification-list" v-if="products">
                <RouterLink v-for="(item, index) in products" v-bind:key="index" :to="item.slug"
                    class="dropdown-item notify-item">
                    <div class="d-flex"><img class="d-flex me-2 rounded-circle" :src="firstImage(item)"
                            alt="Generic placeholder image" height="32">
                        <div class="w-100 d-grid">
                            <h5 class="m-0 font-14 text-ellipsis-1 d-block">{{ item.name }}</h5>
                            <span class="font-12 mb-0 text-price text-danger">
                                {{ formatCurrency(saleProduct(item.price, item.sale)) }} đ
                            </span>
                        </div>
                    </div>
                </RouterLink>
            </div>
        </div>
    </div>
</template>

<script>
import api from "../../stores/axios"
import { domain, formatCurrency, saleProduct } from "../../config"

export default {
    data() {
        return {
            keywords: '',
            products: null,
        }
    },
    computed: {

    },
    methods: {
        firstImage(item) {
            const images = JSON.parse(item.images)

            if (images.length > 0) {
                console.log(images)
                return domain + images[0].image;
            } else {
                return null;
            }
        },
        saleProduct(price, sale) {
            return saleProduct(price, sale);
        },
        formatCurrency(price) {
            return formatCurrency(price);
        },
        search() {
            api.get('api/search?q=' + this.keywords, {
                'Content-Type': 'application/json',
            }, this)
                .then(response => {
                    this.products = response.data.data;
                    console.log(response)
                })
                .catch(error => {
                    console.log(error);
                });
        }
    },
    watch: {
        keywords() {
            if (this.keywords.length < 3) {
                return
            }
            this.search();
        }
    }
}
</script>
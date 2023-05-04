<template>
    <Breadcrumb :items="breadcrumb_arr()" />
    <div v-if="isLoading">Loading...</div>
    <div v-else>
        <ProductDetail :product="product" :rates="rates" />
    </div>
    <!-- <Products /> -->
    <div class="container">
        <div class=" dev">

            <div class="row">
                <div class="col-xxl-9 col-lg-12 order-lg-2 order-xxl-1">
                    <!-- new post -->
                    <div class="card">
                        <div class="card-body p-0">
                            <ul class="nav nav-tabs nav-bordered" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a href="#newpost" data-bs-toggle="tab" aria-expanded="false"
                                        class="nav-link active px-3 py-2" aria-selected="true" role="tab">
                                        <i class="mdi mdi-pencil-box-multiple font-18 d-md-none d-block"></i>
                                        <span class="d-none d-md-block">Create Post</span>
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a href="#photo-video" data-bs-toggle="tab" aria-expanded="true"
                                        class="nav-link px-3 py-2" aria-selected="false" tabindex="-1" role="tab">
                                        <i class="mdi mdi-image font-18 d-md-none d-block"></i>
                                        <span class="d-none d-md-block">Photos/Videos</span>
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a href="#story" data-bs-toggle="tab" aria-expanded="true" class="nav-link px-3 py-2"
                                        aria-selected="false" tabindex="-1" role="tab">
                                        <i class="mdi mdi-book-open-variant font-18 d-md-none d-block"></i>
                                        <span class="d-none d-md-block">Story</span>
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane show active p-3" id="newpost" role="tabpanel">
                                    <div class="border rounded">
                                        <form action="#" class="comment-area-box">
                                            <textarea rows="4" class="form-control border-0 resize-none"
                                                placeholder="Write something...."></textarea>
                                            <div class="p-2 bg-light d-flex justify-content-between align-items-center">
                                                <div>
                                                    <a href="#" class="btn btn-sm px-2 font-16 btn-light"><i
                                                            class="uil uil-scenery"></i></a>
                                                    <a href="#" class="btn btn-sm px-2 font-16 btn-light"><i
                                                            class="uil uil-location"></i></a>
                                                    <a href="#" class="btn btn-sm px-2 font-16 btn-light"><i
                                                            class="uil uil-paperclip"></i></a>
                                                </div>
                                                <button type="submit" class="btn btn-sm btn-success"><i
                                                        class="uil uil-message me-1"></i>Post</button>
                                            </div>
                                        </form>
                                    </div> <!-- end .border-->
                                    <!-- end comment box -->
                                </div> <!-- end preview-->
                            </div> <!-- end tab-content-->
                        </div>
                    </div>
                    <!-- end new post -->

                    <div class="card">
                        <div class="card-body">
                            <template v-if="rates" v-for="(item, index) in rates.rates" v-bind:key="index">
                                <div class="d-flex">
                                    <img v-if="item.user.avatar" class="me-2 rounded"
                                        :src="'http://localhost:8000/images/users/' + item.user.avatar"
                                        alt="Generic placeholder image" height="32">
                                    <img v-else class="me-2 rounded" src="http://localhost:8000/images/users/avatar.png"
                                        alt="Generic placeholder image" height="32">
                                    <div class="w-100">
                                        <div class="dropdown float-end text-muted">
                                            <a href="#" class="dropdown-toggle arrow-none card-drop"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-dots-horizontal"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a href="javascript:void(0);" class="dropdown-item">Edit</a>
                                                <a href="javascript:void(0);" class="dropdown-item">Delete</a>
                                            </div>
                                        </div>
                                        <h5 class="m-0">{{ item.user.name }}</h5>
                                        <p class="text-muted m-0">
                                            <small>about 2 minuts ago <span class="mx-1">⚬</span>
                                                <span>Public</span></small>
                                        </p>
                                    </div>
                                </div>

                                <Stars :rate="item.rate.toString()" />
                                <div class="text-dark">
                                    {{ item.content }}
                                </div>

                                <hr class="">
                            </template>

                        </div>
                    </div>

                    <div class="text-center mb-3">
                        <a href="javascript:void(0);" class="text-danger">
                            <i class="mdi mdi-spin mdi-loading me-1 font-16"></i>
                            Xem thêm
                        </a>
                    </div>
                </div>
            </div>
            <Products v-if="item.name" :item="item" />

        </div>
    </div>
</template>

<script>
import Products from "../../components/Product/Products.vue";
import ProductDetail from "../../components/Product/ProductDetail.vue";
import Breadcrumb from "../../components/Breadcrumb.vue";
import Stars from "@/components/Rate/Index.vue";

export default {
    data() {
        return {
            slug: '',
            item: { name: null, slug: null, limit: 10, page: 1 },
        }
    },
    components: {
        Products,
        ProductDetail,
        Breadcrumb,
        Stars,
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
        rates() {
            return this.$store.getters.rates
        },
        isLoading() {
            return this.$store.getters.isLoading
        }
    },
    mounted() {
        const loadData = async () => {
            await this.$store.dispatch('isLoading', true)
            await this.$store.dispatch('productDetail', this.slug)
            await this.$store.dispatch('isLoading', false)
            this.item.name = this.product.category.name
            this.item.slug = this.product.category.slug
            await this.$store.dispatch('rateOfProduct', this.product.id)
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
        this.$store.dispatch('rateOfProduct', this.product.id)
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
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
                    <div class="card">
                        <div class="card-body boxReview ">
                            <h1 class="h3 text-dark">{{ product.name }}</h1>
                            <div v-if="rates" class="boxReview-review is-flex"><!---->
                                <div class="boxReview-score is-flex is-justify-content-center is-align-items-center">
                                    <p class="title is-4 m-0 p-0">{{ rates.detail.average }}/5</p>
                                    <div class="d-flex">
                                        <div icon="star" class="icon is-active"><svg height="15"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                <path
                                                    d="M381.2 150.3L524.9 171.5C536.8 173.2 546.8 181.6 550.6 193.1C554.4 204.7 551.3 217.3 542.7 225.9L438.5 328.1L463.1 474.7C465.1 486.7 460.2 498.9 450.2 506C440.3 513.1 427.2 514 416.5 508.3L288.1 439.8L159.8 508.3C149 514 135.9 513.1 126 506C116.1 498.9 111.1 486.7 113.2 474.7L137.8 328.1L33.58 225.9C24.97 217.3 21.91 204.7 25.69 193.1C29.46 181.6 39.43 173.2 51.42 171.5L195 150.3L259.4 17.97C264.7 6.954 275.9-.0391 288.1-.0391C300.4-.0391 311.6 6.954 316.9 17.97L381.2 150.3z">
                                                </path>
                                            </svg></div>
                                        <div icon="star" class="icon is-active"><svg height="15"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                <path
                                                    d="M381.2 150.3L524.9 171.5C536.8 173.2 546.8 181.6 550.6 193.1C554.4 204.7 551.3 217.3 542.7 225.9L438.5 328.1L463.1 474.7C465.1 486.7 460.2 498.9 450.2 506C440.3 513.1 427.2 514 416.5 508.3L288.1 439.8L159.8 508.3C149 514 135.9 513.1 126 506C116.1 498.9 111.1 486.7 113.2 474.7L137.8 328.1L33.58 225.9C24.97 217.3 21.91 204.7 25.69 193.1C29.46 181.6 39.43 173.2 51.42 171.5L195 150.3L259.4 17.97C264.7 6.954 275.9-.0391 288.1-.0391C300.4-.0391 311.6 6.954 316.9 17.97L381.2 150.3z">
                                                </path>
                                            </svg></div>
                                        <div icon="star" class="icon is-active"><svg height="15"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                <path
                                                    d="M381.2 150.3L524.9 171.5C536.8 173.2 546.8 181.6 550.6 193.1C554.4 204.7 551.3 217.3 542.7 225.9L438.5 328.1L463.1 474.7C465.1 486.7 460.2 498.9 450.2 506C440.3 513.1 427.2 514 416.5 508.3L288.1 439.8L159.8 508.3C149 514 135.9 513.1 126 506C116.1 498.9 111.1 486.7 113.2 474.7L137.8 328.1L33.58 225.9C24.97 217.3 21.91 204.7 25.69 193.1C29.46 181.6 39.43 173.2 51.42 171.5L195 150.3L259.4 17.97C264.7 6.954 275.9-.0391 288.1-.0391C300.4-.0391 311.6 6.954 316.9 17.97L381.2 150.3z">
                                                </path>
                                            </svg></div>
                                        <div icon="star" class="icon is-active"><svg height="15"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                <path
                                                    d="M381.2 150.3L524.9 171.5C536.8 173.2 546.8 181.6 550.6 193.1C554.4 204.7 551.3 217.3 542.7 225.9L438.5 328.1L463.1 474.7C465.1 486.7 460.2 498.9 450.2 506C440.3 513.1 427.2 514 416.5 508.3L288.1 439.8L159.8 508.3C149 514 135.9 513.1 126 506C116.1 498.9 111.1 486.7 113.2 474.7L137.8 328.1L33.58 225.9C24.97 217.3 21.91 204.7 25.69 193.1C29.46 181.6 39.43 173.2 51.42 171.5L195 150.3L259.4 17.97C264.7 6.954 275.9-.0391 288.1-.0391C300.4-.0391 311.6 6.954 316.9 17.97L381.2 150.3z">
                                                </path>
                                            </svg></div>
                                        <div icon="star" class="icon is-active"><svg height="15"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                <path
                                                    d="M381.2 150.3L524.9 171.5C536.8 173.2 546.8 181.6 550.6 193.1C554.4 204.7 551.3 217.3 542.7 225.9L438.5 328.1L463.1 474.7C465.1 486.7 460.2 498.9 450.2 506C440.3 513.1 427.2 514 416.5 508.3L288.1 439.8L159.8 508.3C149 514 135.9 513.1 126 506C116.1 498.9 111.1 486.7 113.2 474.7L137.8 328.1L33.58 225.9C24.97 217.3 21.91 204.7 25.69 193.1C29.46 181.6 39.43 173.2 51.42 171.5L195 150.3L259.4 17.97C264.7 6.954 275.9-.0391 288.1-.0391C300.4-.0391 311.6 6.954 316.9 17.97L381.2 150.3z">
                                                </path>
                                            </svg></div>
                                    </div>
                                    <p><strong>{{ rates.detail.count }}</strong> đánh giá và nhận xét</p>
                                </div>
                                <div class="boxReview-star is-flex is-justify-content-space-evenly">
                                    <div class="rating-level is-flex is-align-items-center is-justify-content-space-evenly">
                                        <div class="star-count is-flex is-align-items-center"><span
                                                class="has-text-weight-bold">5</span>
                                            <div class="is-active">
                                                <svg height="15" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                    <path
                                                        d="M381.2 150.3L524.9 171.5C536.8 173.2 546.8 181.6 550.6 193.1C554.4 204.7 551.3 217.3 542.7 225.9L438.5 328.1L463.1 474.7C465.1 486.7 460.2 498.9 450.2 506C440.3 513.1 427.2 514 416.5 508.3L288.1 439.8L159.8 508.3C149 514 135.9 513.1 126 506C116.1 498.9 111.1 486.7 113.2 474.7L137.8 328.1L33.58 225.9C24.97 217.3 21.91 204.7 25.69 193.1C29.46 181.6 39.43 173.2 51.42 171.5L195 150.3L259.4 17.97C264.7 6.954 275.9-.0391 288.1-.0391C300.4-.0391 311.6 6.954 316.9 17.97L381.2 150.3z">
                                                    </path>
                                                </svg>
                                            </div>
                                        </div>
                                        <progress max="1" value="1" class="progress is-small m-0"></progress>
                                        <span class="is-size-7">1 đánh giá</span>
                                    </div>
                                    <div class="rating-level is-flex is-align-items-center is-justify-content-space-evenly">
                                        <div class="star-count is-flex is-align-items-center">
                                            <span class="has-text-weight-bold">4</span>
                                            <div class="is-active">
                                                <svg height="15" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                    <path
                                                        d="M381.2 150.3L524.9 171.5C536.8 173.2 546.8 181.6 550.6 193.1C554.4 204.7 551.3 217.3 542.7 225.9L438.5 328.1L463.1 474.7C465.1 486.7 460.2 498.9 450.2 506C440.3 513.1 427.2 514 416.5 508.3L288.1 439.8L159.8 508.3C149 514 135.9 513.1 126 506C116.1 498.9 111.1 486.7 113.2 474.7L137.8 328.1L33.58 225.9C24.97 217.3 21.91 204.7 25.69 193.1C29.46 181.6 39.43 173.2 51.42 171.5L195 150.3L259.4 17.97C264.7 6.954 275.9-.0391 288.1-.0391C300.4-.0391 311.6 6.954 316.9 17.97L381.2 150.3z">
                                                    </path>
                                                </svg>
                                            </div>
                                        </div>
                                        <progress max="1" value="0" class="progress is-small m-0"></progress>
                                        <span class="is-size-7">0 đánh giá</span>
                                    </div>
                                    <div class="rating-level is-flex is-align-items-center is-justify-content-space-evenly">
                                        <div class="star-count is-flex is-align-items-center">
                                            <span class="has-text-weight-bold">3</span>
                                            <div class="is-active">
                                                <svg height="15" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                    <path
                                                        d="M381.2 150.3L524.9 171.5C536.8 173.2 546.8 181.6 550.6 193.1C554.4 204.7 551.3 217.3 542.7 225.9L438.5 328.1L463.1 474.7C465.1 486.7 460.2 498.9 450.2 506C440.3 513.1 427.2 514 416.5 508.3L288.1 439.8L159.8 508.3C149 514 135.9 513.1 126 506C116.1 498.9 111.1 486.7 113.2 474.7L137.8 328.1L33.58 225.9C24.97 217.3 21.91 204.7 25.69 193.1C29.46 181.6 39.43 173.2 51.42 171.5L195 150.3L259.4 17.97C264.7 6.954 275.9-.0391 288.1-.0391C300.4-.0391 311.6 6.954 316.9 17.97L381.2 150.3z">
                                                    </path>
                                                </svg>
                                            </div>
                                        </div>
                                        <progress max="1" value="0.5" class="progress is-small m-0"></progress>
                                        <span class="is-size-7">0 đánh giá</span>
                                    </div>
                                    <div class="rating-level is-flex is-align-items-center is-justify-content-space-evenly">
                                        <div class="star-count is-flex is-align-items-center">
                                            <span class="has-text-weight-bold">2</span>
                                            <div class="is-active">
                                                <svg height="15" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                    <path
                                                        d="M381.2 150.3L524.9 171.5C536.8 173.2 546.8 181.6 550.6 193.1C554.4 204.7 551.3 217.3 542.7 225.9L438.5 328.1L463.1 474.7C465.1 486.7 460.2 498.9 450.2 506C440.3 513.1 427.2 514 416.5 508.3L288.1 439.8L159.8 508.3C149 514 135.9 513.1 126 506C116.1 498.9 111.1 486.7 113.2 474.7L137.8 328.1L33.58 225.9C24.97 217.3 21.91 204.7 25.69 193.1C29.46 181.6 39.43 173.2 51.42 171.5L195 150.3L259.4 17.97C264.7 6.954 275.9-.0391 288.1-.0391C300.4-.0391 311.6 6.954 316.9 17.97L381.2 150.3z">
                                                    </path>
                                                </svg>
                                            </div>
                                        </div>
                                        <progress max="1" value="0" class="progress is-small m-0">
                                        </progress>
                                        <span class="is-size-7">0 đánh giá</span>
                                    </div>
                                    <div class="rating-level is-flex is-align-items-center is-justify-content-space-evenly">
                                        <div class="star-count is-flex is-align-items-center">
                                            <span class="has-text-weight-bold">1</span>
                                            <div class="is-active">
                                                <svg height="15" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                    <path
                                                        d="M381.2 150.3L524.9 171.5C536.8 173.2 546.8 181.6 550.6 193.1C554.4 204.7 551.3 217.3 542.7 225.9L438.5 328.1L463.1 474.7C465.1 486.7 460.2 498.9 450.2 506C440.3 513.1 427.2 514 416.5 508.3L288.1 439.8L159.8 508.3C149 514 135.9 513.1 126 506C116.1 498.9 111.1 486.7 113.2 474.7L137.8 328.1L33.58 225.9C24.97 217.3 21.91 204.7 25.69 193.1C29.46 181.6 39.43 173.2 51.42 171.5L195 150.3L259.4 17.97C264.7 6.954 275.9-.0391 288.1-.0391C300.4-.0391 311.6 6.954 316.9 17.97L381.2 150.3z">
                                                    </path>
                                                </svg>
                                            </div>
                                        </div>
                                        <progress max="1" value="0" class="progress is-small m-0">
                                        </progress>
                                        <span class="is-size-7">0 đánh giá</span>
                                    </div>
                                </div>

                            </div>
                            <p class="has-text-centered my-2 subtitle is-6">Bạn đánh giá sao sản phẩm này</p>
                            <div class="has-text-centered">
                                <button class="button has-text-white" data-bs-toggle="modal" data-bs-target="#bs-rate">Đánh
                                    giá ngay</button>
                            </div>
                        </div>

                    </div>

                    <div class="modal fade" id="bs-rate" tabindex="-1" aria-labelledby="bs-rate" aria-modal="true"
                        role="dialog">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header text-bg-danger border-0">
                                    <h4 class="modal-title text-light" id="myLargeModalLabel">Thêm đánh giá</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div>
                                        <form class="comment-area-box">
                                            <div class="mb-3">
                                                <label class="form-label text-dark">Sao:</label>
                                                <input class="form-control" type="number" min="1" max="5" v-model="rate" />
                                                <template v-if="errors" v-for="(item, index) in errors.rate"
                                                    v-bind:key="index">
                                                    <span class="text-danger">{{ item }}</span>
                                                </template>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-dark">Nội dung:</label>
                                                <textarea v-model="content" rows="4" class="form-control resize-none"
                                                    placeholder="Write something...."></textarea>
                                                <template v-if="errors" v-for="(item, index) in errors.content"
                                                    v-bind:key="index">
                                                    <span class="text-danger">{{ item }}</span>
                                                </template>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button @click="sendRate()" class="btn btn-sm btn-success">
                                        <i class="uil uil-message me-1"></i> Gửi đánh giá
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
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
import api from '../../stores/axios'

export default {
    data() {
        return {
            slug: '',
            item: { name: null, slug: null, limit: 10, page: 1 },
            rate: '',
            content: '',
            errors: null,
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
        async sendRate() {
            if (!this.auth) {
                alert('danger', 'top-center', 'Bạn cần đăng nhập để tiếp tục.');
                this.$router.push('/login');
                return;
            }
            let form = await new FormData()
            await form.append('product_id', this.product.id)
            await form.append('rate', this.rate)
            await form.append('content', this.content)
            try {
                const data = await api.post('api/rate', form, {
                    'Content-Type': 'multipart/form-data',
                    'Authorization': 'Bearer ' + this.auth.access_token
                }, this)
                await alert('Đã thêm 1 đánh giá mới.');
                this.loadData()
                $("#bs-rate").modal('hide');
            } catch (e) {
                console.log(e)
                if (e.errors) {
                    this.errors = e.errors
                }
            }
        },
        async loadData() {
            await this.$store.dispatch('isLoading', true)
            await this.$store.dispatch('productDetail', this.slug)
            await this.$store.dispatch('isLoading', false)
            this.item.name = this.product.category.name
            this.item.slug = this.product.category.slug
            await this.$store.dispatch('rateOfProduct', this.product.id)
        }
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
        },
        auth() {
            return this.$store.getters.auth
        },
    },
    mounted() {
        this.loadData();
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
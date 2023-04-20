<template>
    <section>
        <div class="container">
            <div class="block-hot-sale">
                <div class="box-title mb-4">
                    <div class="box-tab-menu">
                        <p class="box-tab-item active text-light">
                            Điện thoại,Laptop,TV</p>
                        <p class="box-tab-item bg-light text-c-red">
                            Phụ kiện</p>
                    </div>
                    <div class="title-image">
                        <div class="text-center"><img src="https://cdn2.cellphones.com.vn/600x,webp/media/wysiwyg/hst.png"
                                alt="title" loading="lazy"></div>
                    </div>
                    <div class="box-countdown">
                        <p class="title">Bắt đầu sau: </p>
                        <ul class="box-time">
                            <li>
                                <p class="time">00</p>
                                <p class="separate">:</p>
                            </li>
                            <li>
                                <p class="time">13</p>
                                <p class="separate">:</p>
                            </li>
                            <li>
                                <p class="time">18</p>
                                <p class="separate">:</p>
                            </li>
                            <li>
                                <p class="time">19</p>
                                <p class="separate"></p>
                            </li>
                        </ul>
                    </div>
                </div> <!---->
                <div class="box-content">
                    <div class="product-list-swiper row p-1">
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 col-xxl-2 mb-3"
                            v-for="(product, index) in products" v-bind:key="index">
                            <Item :product="product" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import Item from "./Item.vue";

export default {
    mounted() {
        this.$store.dispatch('hotSale')
    },
    computed: {
        products() {
            return this.$store.getters.hotSale
        },
    },
    components: {
        Item,
    },
}
</script>

<style lang="scss" scoped>
@media (min-width: 1200px) {
    .col-xl-2 {
        -webkit-box-flex: 0;
        -ms-flex: 0 0 auto;
        flex: 0 0 auto;
        width: 20%;
    }
}
</style>
<template>
    <swiper :style="{
        '--swiper-navigation-color': '#fff',
        '--swiper-pagination-color': '#fff',
    }" :loop="true" :spaceBetween="10" :navigation="true" :thumbs="{ swiper: thumbsSwiper }" :modules="modules"
        :autoplay="{
            delay: 3000,
            disableOnInteraction: false,
        }" class="mySwiper2 rounded-1 swiper-image">

        <swiper-slide v-for="(image, index) in images_data" v-bind:key="index">
            <img :src="domain + image.image" :alt="name" />
        </swiper-slide>

    </swiper>

    <swiper @swiper="setThumbsSwiper" :loop="true" :spaceBetween="10" :slidesPerView="4" :freeMode="true"
        :watchSlidesProgress="true" :modules="modules" class="mySwiper">
        <swiper-slide v-for="(image, index) in images_data" v-bind:key="index">
            <img :src="domain + image.image" :alt="name" />
        </swiper-slide>
    </swiper>
</template>

<script>
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import "swiper/css/free-mode"
import "swiper/css/navigation"
import "swiper/css/thumbs"
import { domain } from "../../config"
import { Autoplay, FreeMode, Navigation, Thumbs } from 'swiper';

export default {
    props: {
        images: String,
        name: String,
    },
    data() {
        return {
            thumbsSwiper: null,
            domain: domain
        }
    },
    components: {
        Swiper,
        SwiperSlide,
    },
    methods: {
        setThumbsSwiper(swiper) {
            this.thumbsSwiper = swiper;
        },
    },
    computed: {
        images_data() {
            if (this.images) {
                return JSON.parse(this.images)
            } else {
                return null;
            }
        },
    },
    setup() {
        return {
            modules: [Autoplay, FreeMode, Navigation, Thumbs],
        };
    }
}
</script>
  
<style lang="scss">
.swiper-image:hover .swiper-button-next,
.swiper-image:hover .swiper-button-prev {
    display: flex;
}

.swiper-button-next,
.swiper-button-prev {
    --swiper-navigation-size: 26px;
    --swiper-navigation-size: 26px;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #ddd;
    opacity: .5;
    color: black;
    transition: .3s;
    display: none;
}

.swiper-button-next:hover,
.swiper-button-prev:hover {
    opacity: .8;
}

.mySwiper .swiper-slide-thumb-active {
    opacity: 1;
    border: #0bbf56 1px solid;
}

.swiper-image {
    box-shadow: 0 1px 2.94px 0.06px rgba(4, 26, 55, .16);
    border: 0 solid rgba(0, 0, 0, .125);
}

.swiper {
    width: 100%;
    height: 300px;
    margin-left: auto;
    margin-right: auto;
}

.swiper-slide {
    background-size: cover;
    background-position: center;
}

.mySwiper2 {
    height: 80%;
    width: 100%;
}

.mySwiper {
    height: 20%;
    box-sizing: border-box;
    padding: 10px 0;
}

.mySwiper .swiper-slide {
    width: 25%;
    height: 100%;
    opacity: 0.7;
    padding: 3px;
}

.mySwiper .swiper-slide-thumb-active {
    opacity: 1;
}

.swiper-slide img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
}
</style>

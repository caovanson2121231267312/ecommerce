<template>
    <div class="h-100">
        <swiper :spaceBetween="30" :centeredSlides="true" :autoplay="{
            delay: 3500,
            disableOnInteraction: false,
        }" :pagination="{
    clickable: true,
}" :navigation="true" :loop="true" :modules="modules" @autoplayTimeLeft="onAutoplayTimeLeft" class="mySwiper">
            <swiper-slide>
                <RouterLink class="w-100 b-block" to="/">
                    <img :src="images.bg1" class="img-fluid" alt="cao van son" />
                </RouterLink>
            </swiper-slide>
            <swiper-slide>
                <RouterLink class="w-100 b-block" to="/">
                    <img :src="images.bg9" class="img-fluid" alt="cao van son" />
                </RouterLink>
            </swiper-slide>
            <swiper-slide>
                <RouterLink class="w-100 b-block" to="/">
                    <img :src="images.bg2" class="img-fluid" alt="cao van son" />
                </RouterLink>
            </swiper-slide>
            <swiper-slide>
                <RouterLink class="w-100 b-block" to="/">
                    <img :src="images.bg3" class="img-fluid" alt="cao van son" />
                </RouterLink>
            </swiper-slide>
            <swiper-slide>
                <RouterLink class="w-100 b-block" to="/">
                    <img :src="images.bg4" class="img-fluid" alt="cao van son" />
                </RouterLink>
            </swiper-slide>
            <swiper-slide>
                <RouterLink class="w-100 b-block" to="/">
                    <img :src="images.bg5" class="img-fluid" alt="cao van son" />
                </RouterLink>
            </swiper-slide>
            <swiper-slide>
                <RouterLink class="w-100 b-block" to="/">
                    <img :src="images.bg6" class="img-fluid" alt="cao van son" />
                </RouterLink>
            </swiper-slide>
            <swiper-slide>
                <RouterLink class="w-100 b-block" to="/">
                    <img :src="images.bg7" class="img-fluid" alt="cao van son" />
                </RouterLink>
            </swiper-slide>
            <swiper-slide>
                <RouterLink class="w-100 b-block" to="/">
                    <img :src="images.bg8" class="img-fluid" alt="cao van son" />
                </RouterLink>
            </swiper-slide>
            <swiper-slide>
                <RouterLink class="w-100 b-block" to="/">
                    <img :src="images.bg10" class="img-fluid" alt="cao van son" />
                </RouterLink>
            </swiper-slide>
            <template #container-end>
                <div class="autoplay-progress">
                    <svg viewBox="0 0 48 48" ref="progressCircle">
                        <circle cx="24" cy="24" r="20"></circle>
                    </svg>
                    <span ref="progressContent"></span>
                </div>
            </template>
        </swiper>
    </div>
</template>

<script>
import { Swiper, SwiperSlide } from 'swiper/vue';
import { ref } from 'vue';
import { RouterLink } from 'vue-router'
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';
import { Autoplay, Pagination, Navigation } from 'swiper';
import images from "@/assets/images/index.js";

export default {
    components: {
        Swiper,
        SwiperSlide,
    },
    computed: {
        images() {
            return images;
        }
    },
    setup() {
        const progressCircle = ref(null);
        const progressContent = ref(null);
        const onAutoplayTimeLeft = (s, time, progress) => {
            progressCircle.value.style.setProperty('--progress', 1 - progress);
            progressContent.value.textContent = `${Math.ceil(time / 1000)}s`;
        };
        return {
            onAutoplayTimeLeft,
            progressCircle,
            progressContent,
            modules: [Autoplay, Pagination, Navigation],
        };
    },
};
</script>


<style scoped lang="scss">
.swiper {
    width: 100%;
    height: 100%;
}

.swiper-slide {
    text-align: center;
    font-size: 18px;
    background: #fff;
    display: flex;
    justify-content: center;
    // align-items: center;
}

.swiper-slide img {
    display: block;
    width: 100%;
    // height: 100%;
    object-fit: cover;
}

.autoplay-progress {
    position: absolute;
    right: 16px;
    bottom: 16px;
    z-index: 10;
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    color: var(--swiper-theme-color);
}

.autoplay-progress svg {
    --progress: 0;
    position: absolute;
    left: 0;
    top: 0px;
    z-index: 10;
    width: 100%;
    height: 100%;
    stroke-width: 4px;
    stroke: var(--swiper-theme-color);
    fill: none;
    stroke-dashoffset: calc(125.6 * (1 - var(--progress)));
    stroke-dasharray: 125.6;
    transform: rotate(-90deg);
}
</style>
<template>
    <section class="mt-3">
        <div class="container">
            <div class="banner card">
                <div class="card-body p-2">
                    <div class="row h-100">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-9 col-xl-9 col-xxl-9">
                            <div class="row h-100">
                                <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 col-xxl-3">
                                    <Category v-if="categories" :categories="categories" />
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-9 col-xl-9 col-xxl-9 h-100">
                                    <Banner />
                                </div>
                            </div>
                        </div>
                        <div class="col-3 col-sm-3">
                            <div class="row">
                                <div class="col-12">
                                    <RouterLink class="d-block mb-3" to="">
                                        <img class="img-thumbnail" :src="images.bg10" />
                                    </RouterLink>
                                </div>
                                <div class="col-12">
                                    <RouterLink class="d-block mb-1" to="">
                                        <img class="img-thumbnail" :src="images.bg9" />
                                    </RouterLink>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import Banner from "./Banner.vue"
import Category from "./Category.vue"
import images from "@/assets/images/index.js";

export default {
    components: {
        Banner,
        Category,
    },
    computed: {
        categories() {
            return this.$store.getters.categories
        },
        isLoading() {
            return this.$store.getters.isLoading
        },
        images() {
            return images;
        }
    },
    mounted() {
        const loadData = async () => {
            // await this.$store.dispatch('isLoading', true)
            await this.$store.dispatch('getCategories')
            // await this.$store.dispatch('isLoading', false)
            // await console.log(this.categories)
        }
        loadData();
    },
}
</script>

<style scoped lang="scss">
.banner {
    height: 342px;
    overflow: hidden;
}
</style>
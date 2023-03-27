<template>
    <section>
        <div class="container">
            <div class="banner card">
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
                        <div>
                            123
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
    height: 376px;
    overflow: hidden;
}
</style>
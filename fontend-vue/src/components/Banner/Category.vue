<template>
    <div class="category">
        <ul>
            <li v-for="(item, index) in categories" v-bind:key="index">
                <RouterLink class="" :to="item.slug">
                    {{ item.name }}
                </RouterLink>
                <div v-if="item.brand">
                    <div>
                        <ul>
                            <li v-for="(brand, i) in item.brand" v-bind:key="i">
                                <RouterLink class="" :to="brand.slug">
                                    {{ brand.name }}
                                </RouterLink>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>
<script setup>
defineProps({
    categories: {
        type: Object,
        required: true,
    },
});
</script>

<script>
import { RouterLink } from 'vue-router'
export default {
    mounted() {
        console.log(this.categories)
    }
}
</script>

<style lang="scss" scoped>
ul {
    margin: 0;
    padding: 0;

    li {
        list-style: none;
        padding-bottom: 10px;
        transition: .3s;

        &:hover {
            color: rgb(6, 70, 209);
            transform: translateX(10px);
        }
    }

    a {
        color: black;
        text-decoration: none;
        transition: .3s;

        &:hover {
            color: rgb(6, 70, 209);
            transform: translateX(-10px);
        }
    }
}
</style>
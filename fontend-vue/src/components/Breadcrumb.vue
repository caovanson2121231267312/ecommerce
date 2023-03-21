<script setup>
defineProps({
    items: {
        type: Array,
        required: true,
    },
});
</script>

<script>
import {
    RouterLink
} from 'vue-router'
</script>

<template>
    <div class="container">
        <div class="mt-3">
            <div>
                <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <RouterLink class="w-full text-decoration-none" to="/">
                                <i class="fas fa-home"></i> Trang chủ
                            </RouterLink>
                        </li>
                        <li class="breadcrumb-item" v-for="(item, index) in items" v-bind:key="index">
                            <RouterLink v-if="index == items.length - 1" class="text-muted text-decoration-none" to="#">
                                {{ item.name }}
                            </RouterLink>
                            <RouterLink v-else class="text-decoration-none" to="#">
                                {{ item.name }}
                            </RouterLink>
                        </li>
                        <!-- <li class="breadcrumb-item"><a href="#">Library</a></li>
                                                                                                                        <li class="breadcrumb-item active" aria-current="page">Data</li> -->
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</template>
<template>
    <nav class="navbar navbar-light navbar-expand-lg pe-5 ps-5" style="background-color: #e3f2fd;">
        <div class="container-fluid">
            <RouterLink class="navbar-brand" to="/">
                <span class="fw-bold">VueJs</span>
                <!-- <img alt="Vue logo" class="logo" src="@/assets/logo.svg" width="25" height="25" /> -->
            </RouterLink>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
                aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                    <li class="nav-item">
                        <RouterLink class="nav-link active" aria-current="page" to="/">
                            Trang chủ
                        </RouterLink>
                    </li>
                    <li class="nav-item">
                        <RouterLink class="nav-link" to="/admin">
                            Aadmin
                        </RouterLink>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Link
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Link</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <form class="d-flex position-relative">
                        <input class="form-control me-2 rounded-1" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-primary position-absolute end-0 rounded-1" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                    <div>
                        <RouterLink class="btn btn-primary ms-2 rounded-1 position-relative" to="/cart">
                            <i class="fas fa-cart-plus"></i>
                            <span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill border border-light bg-danger">
                                {{ cart.length }} <span v-if="cart.length > 0">+</span>
                                <span class="visually-hidden">cart</span>
                            </span>
                        </RouterLink>
                        <RouterLink class="btn btn-success ms-2 rounded-1" to="/login">
                            Đăng nhập
                        </RouterLink>
                        <RouterLink class="btn btn-danger ms-2 rounded-1" to="/signup">
                            Đăng ký
                        </RouterLink>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>

<script setup>
import {
    RouterLink
} from 'vue-router'
</script>

<script>
export default {
    computed: {
        cart() {
            return this.$store.getters.cart
        },
    },
}
</script>

<style scoped lang="scss">
.btn {
    --ct-btn-padding-y: 0.47rem;
}
.navbar-light .navbar-nav .nav-link {
    color: white!important;
}
nav {
    background-color: #d70018!important;
}
</style>
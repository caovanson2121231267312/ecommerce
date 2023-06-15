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
                        <RouterLink class="nav-link active fw-bold" aria-current="page" to="/">
                            Trang chủ
                        </RouterLink>
                    </li>
                    <li class="nav-item">
                        <RouterLink class="nav-link fw-bold" to="/admin">
                            Admin
                        </RouterLink>
                    </li>
                    <li class="nav-item">
                        <RouterLink class="nav-link fw-bold" to="/cart">
                            Giỏ hàng
                        </RouterLink>
                    </li>
                    <li class="nav-item">
                        <RouterLink class="nav-link fw-bold" to="/search-order">
                            Tra cứu đơn hàng
                        </RouterLink>
                    </li>
                </ul>
                <div class="d-flex">
                    <form class="d-flex position-relative">
                        <search-bar />
                    </form>
                    <div class="d-flex">
                        <RouterLink class="btn btn-primary ms-2 rounded-1 position-relative" to="/cart">
                            <i class="fas fa-cart-plus"></i>
                            <span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill border border-light bg-danger">
                                {{ cart.length }} <span v-if="cart.length > 0">+</span>
                                <span class="visually-hidden">cart</span>
                            </span>
                        </RouterLink>
                        <div v-if="auth" class="dropdown ms-2">
                            <a class=" dropdown-toggle arrow-none px-2 d-flex align-items-center btn btn-secondary"
                                data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                                aria-expanded="false">
                                <span class="account-user-avatar  me-1">
                                    <img v-if="auth.user.avatar" :src="domain + 'images/users/' + auth.user.avatar"
                                        :alt="auth.user.email" width="21" class="rounded-circle">
                                    <img v-else src="http://127.0.0.1:8000/images/users/avatar.png" :alt="auth.user.email"
                                        width="21" class="rounded-circle">
                                </span>
                                <span class="d-lg-flex flex-column gap-1 d-none">
                                    <h5 class="my-0 text-light">{{ auth.user.name }}</h5>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated profile-dropdown">
                                <div class="dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Welcome !</h6>
                                </div>
                                <a href="javascript:void(0);" class="dropdown-item"><i
                                        class="mdi mdi-account-circle me-1"></i><span>My Account</span></a>
                                <a href="javascript:void(0);" class="dropdown-item"><i
                                        class="mdi mdi-account-edit me-1"></i><span>Orders</span></a>
                                <a href="javascript:void(0);" class="dropdown-item"><i
                                        class="mdi mdi-lifebuoy me-1"></i><span>Support</span></a>
                                <a href="javascript:void(0);" class="dropdown-item"><i
                                        class="mdi mdi-lock-outline me-1"></i><span>Lock Screen</span></a>
                                <a href="javascript:void(0);" @click="logout" class="dropdown-item">
                                    <i class="mdi mdi-logout me-1"></i><span>Logout</span>
                                </a>
                            </div>
                        </div>
                        <div class="d-none d-md-block" v-else>
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
        </div>
    </nav>
</template>

<script setup>
import {
    RouterLink
} from 'vue-router'
import SearchBar from '../../SearchBar/SearchBar.vue'
import { domain } from "../../../config"
</script>

<script>
export default {
    components: { SearchBar },
    computed: {
        cart() {
            return this.$store.getters.cart
        },
        auth() {
            return this.$store.getters.auth
        },
    },
    methods: {
        logout() {
            this.$store.dispatch('logout', this.auth)

            this.$router.push('/login')
        }
    }
}
</script>

<style scoped lang="scss">
.btn {
    --ct-btn-padding-y: 0.47rem;
}

.navbar-light .navbar-nav .nav-link {
    color: white !important;
}

nav {
    background-color: #d70018 !important;
}
</style>
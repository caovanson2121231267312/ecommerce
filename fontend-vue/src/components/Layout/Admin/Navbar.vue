<template>
    <div class="leftside-menu">

        <!-- Brand Logo Light -->
        <a href="index.html" class="logo logo-light">
            <span class="logo-lg">
                <img src="@/assets/logo.svg" alt="logo">
            </span>
            <span class="logo-sm">
                <img src="@/assets/logo.svg" alt="small logo">
            </span>
        </a>

        <!-- Brand Logo Dark -->
        <a href="index.html" class="logo logo-dark">
            <span class="logo-lg">
                <img src="@/assets/logo.svg" alt="dark logo">
            </span>
            <span class="logo-sm">
                <img src="@/assets/logo.svg" alt="small logo">
            </span>
        </a>

        <!-- Sidebar Hover Menu Toggle Button -->
        <div class="button-sm-hover" data-bs-toggle="tooltip" data-bs-placement="right" title="Show Full Sidebar">
            <i class="ri-checkbox-blank-circle-line align-middle"></i>
        </div>

        <!-- Full Sidebar Menu Close Button -->
        <div class="button-close-fullsidebar">
            <i class="ri-close-fill align-middle"></i>
        </div>

        <!-- Sidebar -left -->
        <div class="h-100" id="leftside-menu-container" data-simplebar="">
            <!-- Leftbar User -->
            <div class="leftbar-user">
                <a href="pages-profile.html">
                    <!-- <img src="assets/images/users/avatar-1.jpg" alt="user-image" height="42"
                        class="rounded-circle shadow-sm"> -->
                    <span class="leftbar-user-name mt-2">Dominic Keller</span>
                </a>
            </div>

            <!--- Sidemenu -->
            <ul class="side-nav">

                <li class="side-nav-title">Navigation</li>

                <li class="side-nav-item">
                    <RouterLink to="/admin" class="side-nav-link">
                        <i class="uil-home-alt"></i>
                        <span class="badge bg-success float-end">6</span>
                        <span> Dashboards </span>
                    </RouterLink>
                </li>

                <li class="side-nav-title">Apps</li>

                <li class="side-nav-item">
                    <a href="apps-calendar.html" class="side-nav-link">
                        <i class="uil-calender"></i>
                        <span> Calendar </span>
                    </a>
                </li>

                <li class="side-nav-item">
                    <RouterLink to="/admin/chat" class="side-nav-link">
                        <i class="uil-comments-alt"></i>
                        <span> Chat </span>
                    </RouterLink>
                </li>

                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarEcommerce" aria-expanded="false"
                        aria-controls="sidebarEcommerce" class="side-nav-link">
                        <i class="uil-store"></i>
                        <span> Ecommerce </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarEcommerce">
                        <ul class="side-nav-second-level">
                            <li>
                                <RouterLink to="/admin/brands">Brands</RouterLink>
                            </li>
                            <li>
                                <RouterLink to="/admin/categories">Categories</RouterLink>
                            </li>
                            <li>
                                <RouterLink to="/admin/products">Products</RouterLink>
                            </li>
                            <li>
                                <RouterLink to="/admin/orders">Orders</RouterLink>
                            </li>
                            <li>
                                <a href="apps-ecommerce-customers.html">Customers</a>
                            </li>
                            <li>
                                <RouterLink to="/admin/tags">Tags</RouterLink>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarAuthorization" aria-expanded="false"
                        aria-controls="sidebarAuthorization" class="side-nav-link">
                        <i class="uil-users-alt"></i>
                        <span> Authorization </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarAuthorization">
                        <ul class="side-nav-second-level">
                            <li>
                                <RouterLink to="/admin/users">Users</RouterLink>
                            </li>
                            <li>
                                <RouterLink to="/admin/roles">Roles</RouterLink>
                            </li>
                            <li>
                                <RouterLink to="/admin/permissions">Permissions</RouterLink>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Help Box -->
                <div class="help-box text-white text-center">
                    <a href="javascript: void(0);" class="float-end close-btn text-white">
                        <i class="mdi mdi-close"></i>
                    </a>
                    <h5 class="mt-3">
                        <i class="fas fa-question"></i>
                        BTL - Nhom 2
                    </h5>
                    <p class="mb-3">Hello everyone</p>
                    <a href="javascript: void(0);" class="btn btn-secondary btn-sm">Admin</a>
                </div>
                <!-- end Help Box -->


            </ul>
            <!--- End Sidemenu -->

            <div class="clearfix"></div>
        </div>
    </div>
</template>

<script>
import {
    RouterLink
} from 'vue-router'


export default {
    mounted() {
        // const a = window.Echo.channel('public').listen('.server.created', (e) => {
        //     console.log('go public');
        //     console.log(e);
        // })
        // console.log(a)

        // to connect the privatechannel
        // window.Echo.private('test-channel.5').listen('server.created', (e) => {
        //     console.log('go private');
        //     //code for displaying the serve data
        //     console.log(e); // the data from the server
        // })
    }
}
</script>
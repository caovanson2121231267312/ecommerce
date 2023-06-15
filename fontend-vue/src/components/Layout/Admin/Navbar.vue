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
                    <span class="leftbar-user-name mt-2">Dominic Keller</span>
                </a>
            </div>

            <ul class="side-nav">

                <li class="side-nav-title">Navigation</li>

                <li class="side-nav-item">
                    <RouterLink to="/admin" class="side-nav-link">
                        <i class="uil-home-alt"></i>
                        <span class="badge bg-success float-end">6</span>
                        <span> {{ $t('dashboards') }} </span>
                    </RouterLink>
                </li>

                <li class="side-nav-item">
                    <RouterLink to="/" class="side-nav-link">
                        <!-- <i class="uil-home-alt"></i> -->
                        <i class="ri-community-fill"></i>
                        <span> Website </span>
                    </RouterLink>
                </li>

                <li class="side-nav-title">Apps</li>

                <li class="side-nav-item">
                    <a href="apps-calendar.html" class="side-nav-link">
                        <i class="uil-calender"></i>
                        <span> {{ $t('calendar') }} </span>
                    </a>
                </li>

                <li class="side-nav-item">
                    <RouterLink to="/admin/chat" class="side-nav-link">
                        <i class="uil-comments-alt"></i>
                        <span> {{ $t('chat') }} </span>
                    </RouterLink>
                </li>

                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarEcommerce" aria-expanded="false"
                        aria-controls="sidebarEcommerce" class="side-nav-link">
                        <i class="uil-store"></i>
                        <span> {{ $t('ecommerce') }} </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarEcommerce">
                        <ul class="side-nav-second-level">
                            <li>
                                <RouterLink to="/admin/brands">{{ $t('brands') }}</RouterLink>
                            </li>
                            <li>
                                <RouterLink to="/admin/categories">{{ $t('categories') }}</RouterLink>
                            </li>
                            <li>
                                <RouterLink to="/admin/products">{{ $t('products') }}</RouterLink>
                            </li>
                            <li>
                                <RouterLink to="/admin/orders">{{ $t('orders') }}</RouterLink>
                            </li>
                            <li>
                                <a href="apps-ecommerce-customers.html">{{ $t('customers') }}</a>
                            </li>
                            <li>
                                <RouterLink to="/admin/tags">{{ $t('tags') }}</RouterLink>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarAuthorization" aria-expanded="false"
                        aria-controls="sidebarAuthorization" class="side-nav-link">
                        <i class="uil-users-alt"></i>
                        <span> {{ $t('authorization') }} </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarAuthorization">
                        <ul class="side-nav-second-level">
                            <li>
                                <RouterLink to="/admin/users">{{ $t('users') }}</RouterLink>
                            </li>
                            <li>
                                <RouterLink to="/admin/roles">{{ $t('roles') }}</RouterLink>
                            </li>
                            <li>
                                <RouterLink to="/admin/permissions">{{ $t('permissions') }}</RouterLink>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Help Box -->
                <div class="help-box text-white text-center">
                    <a href="javascript: void(0);" class="float-end close-btn text-white">
                        <i class="mdi mdi-close"></i>
                    </a>
                    <h5 class="mt-3 text-light">
                        BTL - Nhom 2
                    </h5>
                    <p class="mb-3">{{ $t('hello_everyone') }}</p>
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
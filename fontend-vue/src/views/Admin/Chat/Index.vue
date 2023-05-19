<template>
    <Breadcrumb />
    <div class="row">
        <!-- start chat users-->
        <div class="col-xxl-3 col-xl-6 order-xl-1">
            <div class="card">
                <div class="card-body p-0">
                    <ul class="nav nav-tabs nav-bordered" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a href="#allUsers" data-bs-toggle="tab" aria-expanded="false" class="nav-link py-2 active"
                                aria-selected="true" role="tab">
                                All
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#favUsers" data-bs-toggle="tab" aria-expanded="true" class="nav-link py-2"
                                aria-selected="false" role="tab" tabindex="-1">
                                Favourties
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#friendUsers" data-bs-toggle="tab" aria-expanded="true" class="nav-link py-2"
                                aria-selected="false" role="tab" tabindex="-1">
                                Friends
                            </a>
                        </li>
                    </ul> <!-- end nav-->
                    <div class="tab-content">
                        <div class="tab-pane show active card-body pb-0" id="newpost">

                            <!-- start search box -->
                            <div class="app-search">
                                <form>
                                    <div class="mb-2 w-100 position-relative">
                                        <input type="search" class="form-control"
                                            placeholder="People, groups &amp; messages...">
                                        <span class="mdi mdi-magnify search-icon"></span>
                                    </div>
                                </form>
                            </div>
                            <!-- end search box -->
                        </div>

                        <!-- users -->
                        <div class="row">
                            <div class="col">
                                <div class="card-body py-0 mb-3" data-simplebar="init" style="max-height: 546px">
                                    <div class="simplebar-wrapper" style="margin: 0px -24px;">
                                        <div class="simplebar-height-auto-observer-wrapper">
                                            <div class="simplebar-height-auto-observer"></div>
                                        </div>
                                        <div class="simplebar-mask">
                                            <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                                <div class="simplebar-content-wrapper" tabindex="0" role="region"
                                                    aria-label="scrollable content"
                                                    style="height: auto; overflow: hidden scroll;">
                                                    <div class="simplebar-content" style="padding: 0px 24px;">

                                                        <a v-for="(friend, index) in friends" v-bind:key="index"
                                                            href="javascript:void(0);" class="text-body">
                                                            <div v-if="friend.user_id != auth.user.id"
                                                                class="d-flex align-items-start mt-1 p-2"
                                                                @click="selectUser(friend.user.id)">
                                                                <img :src="domain + friend.user.avatar"
                                                                    class="me-2 rounded-circle" height="43" alt="Ricky J">
                                                                <div class="w-100 overflow-hidden">
                                                                    <h5 class="mt-0 mb-0 font-14">
                                                                        <span
                                                                            class="float-end text-muted font-12">Mon</span>
                                                                        {{ friend.user.name }}
                                                                    </h5>
                                                                    <p class="mt-1 mb-0 text-muted font-14">
                                                                        <span class="w-25 float-end text-end"><span
                                                                                class="badge badge-danger-lighten">28</span></span>
                                                                        <span class="w-75">Are you interested in
                                                                            learning?</span>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div v-else class="d-flex align-items-start mt-1 p-2"
                                                                @click="selectUser(friend.member.id)">
                                                                <img :src="domain + friend.member.avatar"
                                                                    class="me-2 rounded-circle" height="43" alt="Ricky J">
                                                                <div class="w-100 overflow-hidden">
                                                                    <h5 class="mt-0 mb-0 font-14">
                                                                        <span
                                                                            class="float-end text-muted font-12">Mon</span>
                                                                        {{ friend.member.name }}
                                                                    </h5>
                                                                    <p class="mt-1 mb-0 text-muted font-14">
                                                                        <span class="w-25 float-end text-end"><span
                                                                                class="badge badge-danger-lighten">28</span></span>
                                                                        <span class="w-75">Are you interested in
                                                                            learning?</span>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </a>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="simplebar-placeholder" style="width: auto; height: 789px;"></div>
                                    </div>
                                    <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                        <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
                                    </div>
                                    <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                                        <div class="simplebar-scrollbar"
                                            style="height: 377px; transform: translate3d(0px, 0px, 0px); display: block;">
                                        </div>
                                    </div>
                                </div> <!-- end slimscroll-->
                            </div> <!-- End col -->
                        </div> <!-- end users -->
                    </div> <!-- end tab content-->
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div>

        <div class="col-xxl-6 col-xl-12 order-xl-2">
            <div class="card">
                <div class="card-body px-0 pb-0">
                    <ul class="conversation-list px-3" data-simplebar="init" style="max-height: 554px">
                        <div class="simplebar-wrapper" style="margin: 0px -24px;">
                            <div class="simplebar-height-auto-observer-wrapper">
                                <div class="simplebar-height-auto-observer"></div>
                            </div>
                            <div class="simplebar-mask">
                                <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                    <div ref="chatMessages" class="simplebar-content-wrapper" tabindex="0" role="region"
                                        aria-label="scrollable content" style="height: auto; overflow: hidden scroll;">
                                        <div class="simplebar-content" style="padding: 0px 24px;">
                                            <template v-for="(message, index) in messages" v-bind:key="index">
                                                <li class="clearfix" :class="{ 'odd': message.user.id == auth.user.id }">
                                                    <div class="chat-avatar">
                                                        <img :src="domain + message.user.avatar" class="rounded"
                                                            alt="Shreyu N">

                                                    </div>
                                                    <div class="conversation-text">
                                                        <div class="ctext-wrap"
                                                            :class="{ 'bg-primary ctext-wrap-primary text-light': message.user.id == auth.user.id }">
                                                            <i>{{ message.user.name }}</i>
                                                            <p>
                                                                {{ message.content }}
                                                            </p>
                                                        </div>
                                                        <div>
                                                            {{ getFormattedTime(message.created_at) }}
                                                        </div>
                                                    </div>

                                                    <div class="conversation-actions dropdown">
                                                        <button class="btn btn-sm btn-link" data-bs-toggle="dropdown"
                                                            aria-expanded="false"><i
                                                                class="uil uil-ellipsis-v"></i></button>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a class="dropdown-item" href="#">Copy Tin nhắn</a>
                                                            <a class="dropdown-item" href="#">Phản hồi</a>
                                                            <a class="dropdown-item" href="#">Thu hồi</a>
                                                        </div>
                                                    </div>
                                                </li>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="simplebar-placeholder" style="width: auto; height: 935px;"></div>
                        </div>
                        <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                            <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
                        </div>
                        <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                            <div class="simplebar-scrollbar"
                                style="height: 328px; transform: translate3d(0px, 226px, 0px); display: block;"></div>
                        </div>
                    </ul>
                </div> <!-- end card-body -->
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col">
                            <div class="mt-2 bg-light p-3">
                                <form id="chat-form">
                                    <div class="row">
                                        <div class="col mb-2 mb-sm-0">
                                            <input class="form-control border-0" placeholder="Enter your text"
                                                @keyup.enter="sendMessage" v-model="content">
                                            <div class="invalid-feedback">
                                                Please enter your messsage
                                            </div>
                                        </div>
                                        <div class="col-sm-auto">
                                            <div class="btn-group">
                                                <a href="#" class="btn btn-light"><i class="uil uil-paperclip"></i></a>
                                                <a href="#" class="btn btn-light"> <i class="uil uil-smile"></i> </a>
                                                <div class="d-grid">
                                                    <button @click="sendMessage" class="btn btn-success chat-send">
                                                        <i class="uil uil-message"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div> <!-- end col -->
                                    </div> <!-- end row-->
                                </form>
                            </div>
                        </div> <!-- end col-->
                    </div>
                    <!-- end row -->
                </div>
            </div> <!-- end card -->
        </div>

        <div class="col-xxl-3 col-xl-6 order-xl-1 order-xxl-2">
            <div class="card">
                <div class="card-body">
                    <div class="dropdown float-end">
                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="mdi mdi-dots-horizontal"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="javascript:void(0);" class="dropdown-item">View full</a>
                            <a href="javascript:void(0);" class="dropdown-item">Edit Contact Info</a>
                            <a href="javascript:void(0);" class="dropdown-item">Remove</a>
                        </div>
                    </div>

                    <div class="mt-3 text-center">
                        <img src="assets/images/users/avatar-5.jpg" alt="shreyu"
                            class="img-thumbnail avatar-lg rounded-circle">
                        <h4>Shreyu N</h4>
                        <button class="btn btn-primary btn-sm mt-1"><i class="uil uil-envelope-add me-1"></i>Send
                            Email</button>
                        <p class="text-muted mt-2 font-14">Last Interacted: <strong>Few hours back</strong></p>
                    </div>

                    <div class="mt-3">
                        <hr class="">

                        <p class="mt-4 mb-1"><strong><i class="uil uil-at"></i> Email:</strong></p>
                        <p>support@coderthemes.com</p>

                        <p class="mt-3 mb-1"><strong><i class="uil uil-phone"></i> Phone Number:</strong></p>
                        <p>+1 456 9595 9594</p>

                        <p class="mt-3 mb-1"><strong><i class="uil uil-location"></i> Location:</strong></p>
                        <p>California, USA</p>

                        <p class="mt-3 mb-1"><strong><i class="uil uil-globe"></i> Languages:</strong></p>
                        <p>English, German, Spanish</p>

                        <p class="mt-3 mb-2"><strong><i class="uil uil-users-alt"></i> Groups:</strong></p>
                        <p class="mb-0">
                            <span class="badge badge-success-lighten p-1 font-14">Work</span>
                            <span class="badge badge-primary-lighten p-1 font-14">Friends</span>
                        </p>
                    </div>
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div>
    </div>
</template>

<script>
import Breadcrumb from '@/components/Layout/Admin/Breadcrumb.vue';
import api from '../../../stores/axios'
import { domain } from "../../../config"
import moment from 'moment';

export default {
    components: {
        Breadcrumb,
    },
    data() {
        return {
            isOpen: true,
            content: '',
            parent_id: 0,
            user_id: 0,
        };
    },
    computed: {
        auth() {
            return this.$store.getters.auth;
        },
        isLogin() {
            return this.auth ? true : false
        },
        technical_id() {
            return this.$store.getters.technical_id
        },
        messages() {
            return this.$store.getters.messages
        },
        domain() {
            return domain
        },
        friends() {
            return this.$store.getters.friends
        }
    },
    methods: {
        getFormattedTime(timestamp) {
            const now = moment();
            const time = moment(timestamp, 'HH:mm:ss DD/MM/YYYY');
            const diffMinutes = now.diff(time, 'minutes');
            const diffHours = now.diff(time, 'hours');
            const diffDays = now.diff(time, 'days');
            const diffYears = now.diff(time, 'years');

            if (diffMinutes < 2) {
                return 'vừa xong';
            } else if (diffMinutes < 60) {
                return diffMinutes + ' minutes ago';
            } else if (diffDays < 1) {
                return diffHours + ' hours ago';
            } else if (diffDays < 365) {
                return time.format('H:mm D-M');
            } else {
                return diffYears + ' years ago';
            }
        },
        getUsersChat() {
            if (this.auth) {
                api.get('api/get_users_chat', {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + this.auth.access_token
                }, this).then(async response => {
                    console.log(response)
                    await this.$store.dispatch('getFriends', response.data.data);
                    await this.scrollToTop();
                })
            }
        },
        selectUser(id) {
            if (this.auth) {
                this.user_id = id
                api.get('api/messages/' + this.auth.user.id + '/' + id, {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + this.auth.access_token
                }, this).then(async response => {
                    await this.$store.dispatch('messages', response.data.data.messages);
                    await this.scrollToTop();
                })
            }
        },
        async sendMessage(event) {
            event.preventDefault()
            if (!this.content || this.content == '') {
                return
            }
            let form = await new FormData()
            await form.append('content', this.content)
            await form.append('parent_id', this.parent_id)
            api.post('api/messages/create/' + this.user_id, form, {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + this.auth.access_token
            }, this).then(async response => {
                await this.$store.dispatch('addMessage', response.data.data);
                await this.scrollToTop();
                this.content = ''
                this.parent_id = 0
            })
        },
        async toggleChat() {
            this.isOpen = await !this.isOpen;
            await this.scrollToTop();
        },
        scrollToTop() {
            const chatMessages = this.$refs.chatMessages;
            if (chatMessages) {
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        }
    },
    mounted() {
        this.getUsersChat();
        this.scrollToTop();
        if (this.auth) {
            window.Echo.private(`sendToUser.` + this.auth.user.id)
                .listen('.server.created', async (event) => {
                    await this.$store.dispatch('addMessage', event.message);
                    await this.scrollToTop();
                });

            window.Echo.private(`sendToSender.` + this.auth.user.id)
                .listen('.server.created', async (event) => {
                    await this.$store.dispatch('addMessage', event.message);
                    await this.scrollToTop();
                });
        }
    },
}
</script>
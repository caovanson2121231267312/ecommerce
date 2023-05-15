<template>
    <section class="chat">
        <div class="p-3">
            <div v-if="!isOpen" class="rounded-circle btn-chat" @click="toggleChat">
                <i class="far fa-comments fs-2 icon-chat"></i>
            </div>

            <div v-show="isOpen">
                <div class="row d-flex justify-content-center">
                    <div v-if="isLogin" class="col-12">
                        <div v-if="technical_id" class="card" id="chat2">
                            <div class="card-header d-flex justify-content-between align-items-center p-2 bg-danger">
                                <h4 class="mb-0 text-light">
                                    <a>
                                        <i class="fas fa-angle-left cursor-pointer" @click="removeSP"></i>
                                    </a>
                                    <span class="ms-2">{{ technical.name }}</span>
                                </h4>
                                <div class="d-flex">
                                    <div class="me-2 text-light">
                                        <i class="fas fa-ellipsis-v fs-4"></i>
                                    </div>
                                    <div class="text-light close-chat" @click="toggleChat">
                                        <i class="fas fa-times fs-4"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body chat-body m-3" ref="chatMessages">
                                <template v-for="(message, index) in messages" v-bind:key="index">
                                    <div class="d-flex flex-row justify-content-start"
                                        :class="{ 'justify-content-end': message.user.id == auth.user.id }">
                                        <img v-if="message.user.id !== auth.user.id"
                                            class="rounded-circle mt-2 img-thumbnail" :src="domain + message.user.avatar"
                                            :alt="message.user.name" style="width: 45px; height: 100%;">
                                        <div>
                                            <p class="small p-2 m-2 mb-1 rounded-3" style="background-color: #f5f6f7;"
                                                :class="{ 'bg-primary text-white': message.user.id == auth.user.id }">
                                                {{ message.content }}
                                            </p>
                                            <p class="small ms-2 rounded-3 text-muted">
                                                {{ getFormattedTime(message.created_at) }}
                                            </p>
                                        </div>
                                        <img v-if="message.user.id == auth.user.id"
                                            class="rounded-circle mt-2 img-thumbnail" :src="domain + message.user.avatar"
                                            :alt="message.user.name" style="width: 45px; height: 100%;">
                                    </div>
                                </template>
                            </div>
                            <div
                                class="card-footer text-muted d-flex justify-content-start align-items-center p-4  border-3 border-bottom border-danger">
                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3-bg.webp"
                                    alt="avatar 3" style="width: 40px; height: 100%;">
                                <input type="text" v-model="content" class="form-control form-control-lg"
                                    placeholder="Enter message" @keyup.enter="sendMessage">
                                <a class="ms-1 text-muted" href="#!"><i class="fas fa-paperclip"></i></a>
                                <a class="ms-3 text-muted" href="#!"><i class="fas fa-smile"></i></a>
                                <a class="ms-3" href="#!" @click="sendMessage">
                                    <i class="fas fa-paper-plane"></i>
                                </a>
                            </div>
                        </div>
                        <div v-else class="card" id="chat2">
                            <TechnicalSupport :selectSp="selectSp" :toggleChat="toggleChat" />
                            <div
                                class="card-footer text-muted d-flex justify-content-start align-items-center p-4  border-3 border-bottom border-danger">
                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3-bg.webp"
                                    alt="avatar 3" style="width: 40px; height: 100%;">
                                <input type="text" class="form-control form-control-lg" placeholder="Enter message">
                                <a class="ms-1 text-muted" href="#!"><i class="fas fa-paperclip"></i></a>
                                <a class="ms-3 text-muted" href="#!"><i class="fas fa-smile"></i></a>
                                <a class="ms-3" href="#!"><i class="fas fa-paper-plane"></i></a>
                            </div>
                        </div>
                    </div>
                    <div v-else>
                        <CardLogin :toggleChat="toggleChat" />
                    </div>
                </div>
            </div>

        </div>
    </section>
</template>

<script>
import api from '../../stores/axios';
import CardLogin from './CardLogin.vue';
import TechnicalSupport from './TechnicalSupport.vue';
import { domain } from '../../config';
import moment from 'moment';

export default {
    data() {
        return {
            isOpen: true,
            content: '',
            parent_id: 0,
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
            if (this.$store.getters.technical_id) {
                return this.$store.getters.technical_id.id
            }
        },
        technical() {
            return this.$store.getters.technical_id
        },
        messages() {
            return this.$store.getters.messages
        },
        domain() {
            return domain
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
                return diffMinutes + ' phút trước';
            } else if (diffDays < 1) {
                return diffHours + ' giờ trước';
            } else if (diffDays < 365) {
                return time.format('H:mm/D-M');
            } else {
                return diffYears + ' năm trước';
            }
        },
        selectSp(user) {
            this.$store.dispatch('setTechnicalId', user);
            if (this.auth && this.technical_id) {
                api.get('api/messages/' + this.auth.user.id + '/' + this.technical_id, {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + this.auth.access_token
                }, this).then(async response => {
                    await this.$store.dispatch('messages', response.data.data.messages);
                    await this.scrollToTop();
                })
            }
        },
        removeSP() {
            this.$store.dispatch('setTechnicalId', null);
        },
        async sendMessage(e) {
            if (!this.content || this.content == '') {
                return
            }
            let form = await new FormData()
            await form.append('content', this.content)
            await form.append('parent_id', this.parent_id)
            api.post('api/messages/create/' + this.technical_id, form, {
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
    components: { CardLogin, TechnicalSupport }
}
</script>

<style scoped>
.bg-primary {
    --mdb-bg-opacity: 1;
    background-color: rgba(59, 113, 202, 1);
}
</style>
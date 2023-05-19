<template>
    <div class="card-header d-flex justify-content-between align-items-center p-2 bg-danger">
        <h4 class="mb-0 text-light">Chat</h4>
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
        <div class=" p-2">
            <div>
            </div>
            <div v-for="(user, index) in users">
                <div @click="selectSp(user)" class="d-flex align-items-center mb-2 cursor-pointer it-sp" v-bind:key="index">
                    <span class="position-relative me-2">
                        <img width="40" class="img-fluid rounded-circle" :src="domain + user.avatar" />
                        <span class="position-absolute sp-online p-1 bg-success border border-light rounded-circle">
                            <span class="visually-hidden">New alerts</span>
                        </span>
                    </span>
                    <span class="fw-bold text-dark">
                        {{ user.name }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import api from "../../stores/axios"
import { domain } from "../../config";

export default {
    props: {
        selectSp: {
            type: Function,
            require: true,
        },
        toggleChat: {
            type: Function,
            require: true,
        }
    },
    computed: {
        users() {
            return this.$store.getters.technicalSupport
        },
        auth() {
            return this.$store.getters.auth;
        },
        domain() {
            return domain
        }
    },
    mounted() {
        if (this.auth) {
            api.get('api/get_technical_support', {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + this.auth.access_token
            }, this).then(response => {
                this.$store.dispatch('getTechnicalSupport', response.data.data);
            })
        }
    },
}
</script>
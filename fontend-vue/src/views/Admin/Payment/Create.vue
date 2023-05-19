<template>
    <div class="modal fade" id="createModalPayment" tabindex="-1" aria-labelledby="createModalPayment" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-success">
                    <h3 class="modal-title h3 text-light">New Payment</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="col-form-label fw-bold">Card Name:</label>
                            <input v-model="card_name" type="text"
                                :class="{ 'form-control': true, 'is-invalid': errors && errors.card_name }">
                            <template v-if="errors" v-for="(item, index) in errors.card_name" v-bind:key="index">
                                <span class="text-danger">{{ item }}</span>
                            </template>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label fw-bold">Card Number:</label>
                            <input v-model="card_number" type="text"
                                :class="{ 'form-control': true, 'is-invalid': errors && errors.card_number }">
                            <template v-if="errors" v-for="(item, index) in errors.card_number" v-bind:key="index">
                                <span class="text-danger">{{ item }}</span>
                            </template>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">QR:</label>
                            <input class="form-control" type="file" ref="file" v-on:change="onchangeFile"
                                :class="{ 'form-control': true, 'is-invalid': errors && errors.qr }">
                            <template v-if="errors" v-for="(item, index) in errors.qr" v-bind:key="index">
                                <span class="text-danger">{{ item }}</span>
                            </template>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label fw-bold">User Name:</label>
                            <input v-model="user_name" type="text"
                                :class="{ 'form-control': true, 'is-invalid': errors && errors.user_name }">
                            <template v-if="errors" v-for="(item, index) in errors.user_name" v-bind:key="index">
                                <span class="text-danger">{{ item }}</span>
                            </template>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label fw-bold">Phone Number:</label>
                            <input v-model="phone_number" type="text"
                                :class="{ 'form-control': true, 'is-invalid': errors && errors.phone_number }">
                            <template v-if="errors" v-for="(item, index) in errors.phone_number" v-bind:key="index">
                                <span class="text-danger">{{ item }}</span>
                            </template>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label fw-bold">Hash:</label>
                            <input v-model="hash" type="text"
                                :class="{ 'form-control': true, 'is-invalid': errors && errors.hash }">
                            <template v-if="errors" v-for="(item, index) in errors.hash" v-bind:key="index">
                                <span class="text-danger">{{ item }}</span>
                            </template>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" @click="sendData()" class="btn btn-success">Submit</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import api from '../../../stores/axios'
import { alert, notify } from "../../../config"

export default {
    data() {
        return {
            card_number: '',
            card_name: '',
            user_name: '',
            hash: '',
            qr: '',
            phone_number: '',
            errors: null,
        }
    },
    props: {
        loadData: {
            type: Function,
            required: true
        },
    },
    computed: {
        auth() {
            return this.$store.getters.auth
        },
    },
    methods: {
        onchangeFile() {
            this.qr = this.$refs.file.files[0]
        },
        async sendData() {
            if (!this.auth) {
                alert('danger', 'top-center', 'Bạn cần đăng nhập để tiếp tục.');
                this.$router.push('/login');
                return;
            }
            console.log(this.auth.access_token)
            let form = await new FormData()
            await form.append('card_name', this.card_name)
            await form.append('user_name', this.user_name)
            await form.append('phone_number', this.phone_number)
            await form.append('card_number', this.card_number)
            await form.append('hash', this.hash)
            await form.append('qr', this.qr)

            try {
                const data = await api.post('api/admin/payments', form, {
                    'Content-Type': 'multipart/form-data',
                    'Authorization': 'Bearer ' + this.auth.access_token
                }, this)
                await alert('success', 'top-center', 'Đã thêm 1 thẻ thanh toán mới.');
                this.loadData()
                $("#createModalPayment").modal('hide');
            } catch (e) {
                console.log(e)
                if (e.errors) {
                    console.log(e)
                    this.errors = e.errors
                } else {
                    try {
                        notify('danger', 'top-center', JSON.stringify(e));
                    } catch (ex) {
                        alert('danger', 'top-center', 'Đã có lỗi xảy ra vui lòng thử lại.');
                    }
                }
            }
        },
    },
}
</script>
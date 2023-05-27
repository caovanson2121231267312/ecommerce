<template>
    <div class="modal fade" id="createModalpermission" tabindex="-1" aria-labelledby="createModalpermission" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-success">
                    <h3 class="modal-title h3 text-light">New Permission</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="col-form-label fw-bold">Name:</label>
                            <input v-model="name" type="text"
                                :class="{ 'form-control': true, 'is-invalid': errors && errors.name }">
                            <template v-if="errors" v-for="(item, index) in errors.name" v-bind:key="index">
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
            name: '',
            description: '',
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
        async sendData() {
            if (!this.auth) {
                alert('danger', 'top-center', 'Bạn cần đăng nhập để tiếp tục.');
                this.$router.push('/login');
                return;
            }
            console.log(this.auth.access_token)
            let form = await new FormData()
            await form.append('name', this.name)
            await form.append('description', this.description)
            await form.append('parent_id', 0)
            try {
                const data = await api.post('api/admin/permissions', form, {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + this.auth.access_token
                })
                await alert('success', 'top-center', 'Đã thêm 1 danh mục mới.');
                this.loadData()
                $("#createModalpermission").modal('hide');
                this.name = '';
                this.description = '';
                this.errors = null;
            } catch (e) {
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
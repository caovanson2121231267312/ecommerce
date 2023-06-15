<template>
    <Breadcrumb />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-5">
                            <RouterLink to="/admin/roles" class="btn btn-danger mb-2">
                                <i class="fas fa-chevron-left"></i> Back
                            </RouterLink>
                        </div>
                        <div class="col-sm-7">
                            <div class="text-sm-end">
                                <button type="button" class="btn btn-success mb-2 me-1"><i
                                        class="mdi mdi-cog-outline"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <form class="col-md-8">
                            <h3>Add New Role</h3>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Name</label>
                                <input class="form-control" v-model="name"
                                    :class="{ 'form-control': true, 'is-invalid': errors && errors.name }">
                                <template v-if="errors" v-for="(item, index) in errors.name" v-bind:key="index">
                                    <span class="text-danger">{{ item }}</span>
                                </template>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Permissions</label>
                                <div class="row row-cols-3 ps-2">
                                    <div v-for="(item, index) in permissions" v-bind:key="index"
                                        class="form-check form-checkbox-success mb-1">
                                        <input type="checkbox" class="form-check-input" :value="item.id" v-model="check"
                                            @change="handleCheckboxChange">
                                        <label class="form-check-label" for="checkmeout0">{{ item.name }}</label>
                                    </div>
                                </div>
                            </div>
                            <button type="button" @click="sendData()" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
import api from '../../../stores/axios'
import { alert, notify } from "../../../config"
import Breadcrumb from '@/components/Layout/Admin/Breadcrumb.vue';

export default {
    components: {
        Breadcrumb,
    },
    data() {
        return {
            name: '',
            permissions: [],
            errors: null,
            check: [],
        }
    },
    props: {
    },
    computed: {
        auth() {
            return this.$store.getters.auth
        },
    },
    methods: {
        handleCheckboxChange(value) {
            const parsedValue = parseInt(value, 10);
            if (!isNaN(parsedValue)) {
                const index = this.check.indexOf(parsedValue);
                if (index === -1) {
                    this.check.push(parsedValue);
                } else {
                    this.check.splice(index, 1);
                }
            }
        },
        async sendData() {
            let form = await new FormData()
            await form.append('name', this.name)
            for (let i = 0; i < this.check.length; i++) {
                await form.append('permissions[]', this.check[i])
            }
            try {
                const data = await api.post('api/admin/roles', form, {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + this.auth.access_token
                })
                await alert('success', 'top-center', 'Đã thêm 1 roles mới.');
                await this.$router.push('/admin/roles');
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
        async getPermissions() {
            if (!this.auth) {
                alert('danger', 'top-center', 'Bạn cần đăng nhập để tiếp tục.');
                this.$router.push('/login');
                return;
            }
            try {
                const data = await api.get('api/admin/roles/create', {

                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + this.auth.access_token

                })
                this.permissions = await data.data.data
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
        }
    },
    mounted() {
        this.getPermissions();
    }
}
</script>
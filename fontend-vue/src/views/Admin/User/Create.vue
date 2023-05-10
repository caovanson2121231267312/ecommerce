<template>
    <Breadcrumb />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-5">
                            <RouterLink to="/admin/users" class="btn btn-danger mb-2">
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
                            <h3>Add New user</h3>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Name</label>
                                <input class="form-control" v-model="name"
                                    :class="{ 'form-control': true, 'is-invalid': errors && errors.name }">
                                <template v-if="errors" v-for="(item, index) in errors.name" v-bind:key="index">
                                    <span class="text-danger">{{ item }}</span>
                                </template>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Avatar</label>
                                <input class="form-control" type="file" ref="file" v-on:change="onchangeFile"
                                    :class="{ 'form-control': true, 'is-invalid': errors && errors.avatar }">
                                <template v-if="errors" v-for="(item, index) in errors.avatar" v-bind:key="index">
                                    <span class="text-danger">{{ item }}</span>
                                </template>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Email</label>
                                <input class="form-control" v-model="email"
                                    :class="{ 'form-control': true, 'is-invalid': errors && errors.email }">
                                <template v-if="errors" v-for="(item, index) in errors.email" v-bind:key="index">
                                    <span class="text-danger">{{ item }}</span>
                                </template>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Phone number</label>
                                <input class="form-control" v-model="phone_number"
                                    :class="{ 'form-control': true, 'is-invalid': errors && errors.phone_number }">
                                <template v-if="errors" v-for="(item, index) in errors.phone_number" v-bind:key="index">
                                    <span class="text-danger">{{ item }}</span>
                                </template>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Date of birth</label>
                                <input class="form-control" v-model="dob" type="date"
                                    :class="{ 'form-control': true, 'is-invalid': errors && errors.dob }">
                                <template v-if="errors" v-for="(item, index) in errors.dob" v-bind:key="index">
                                    <span class="text-danger">{{ item }}</span>
                                </template>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Gender</label>
                                <div class="row ps-2">
                                    <div class="form-check col-2">
                                        <input class="form-check-input" v-model="gender" value="0" type="radio">
                                        <label class="form-check-label">
                                            Nam
                                        </label>
                                    </div>
                                    <div class="form-check col-2">
                                        <input class="form-check-input" v-model="gender" value="1" type="radio">
                                        <label class="form-check-label">
                                            Nữ
                                        </label>
                                    </div>
                                    <div class="form-check col-2">
                                        <input class="form-check-input" v-model="gender" value="2" type="radio">
                                        <label class="form-check-label">
                                            Khác
                                        </label>
                                    </div>
                                </div>
                                <template v-if="errors" v-for="(item, index) in errors.gender" v-bind:key="index">
                                    <span class="text-danger">{{ item }}</span>
                                </template>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Roles</label>
                                <div v-if="roles.length > 0">
                                    <VueMultiselect v-model="role" :options="roles" :multiple="true"
                                        :close-on-select="false" :clear-on-select="false" :preserve-search="true"
                                        label="name" track-by="name">
                                    </VueMultiselect>
                                </div>
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
                            <div class="mb-3">
                                <label class="form-label fw-bold">Note</label>
                                <textarea :class="{ 'form-control': true, 'is-invalid': errors && errors.note }"
                                    v-model="note"></textarea>
                                <template v-if="errors" v-for="(item, index) in errors.note" v-bind:key="index">
                                    <span class="text-danger">{{ item }}</span>
                                </template>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Password</label>
                                <input class="form-control" v-model="password" type="password"
                                    :class="{ 'form-control': true, 'is-invalid': errors && errors.password }">
                                <template v-if="errors" v-for="(item, index) in errors.password" v-bind:key="index">
                                    <span class="text-danger">{{ item }}</span>
                                </template>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">password_confirmation</label>
                                <input class="form-control" v-model="password_confirmation" type="password"
                                    :class="{ 'form-control': true, 'is-invalid': errors && errors.password_confirmation }">
                                <template v-if="errors" v-for="(item, index) in errors.password_confirmation"
                                    v-bind:key="index">
                                    <span class="text-danger">{{ item }}</span>
                                </template>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Active</label>
                                <div class="row row-cols-3 ps-2">
                                    <div class="form-check form-checkbox-success mb-1">
                                        <input class="form-check-input" v-model="status" type="checkbox"
                                            :class="{ 'form-control': true, 'is-invalid': errors && errors.status }">
                                        <label class="form-check-label" for="checkmeout0">Active</label>
                                    </div>
                                </div>
                                <template v-if="errors" v-for="(item, index) in errors.status" v-bind:key="index">
                                    <span class="text-danger">{{ item }}</span>
                                </template>
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
import VueMultiselect from 'vue-multiselect'

export default {
    components: {
        Breadcrumb,
        VueMultiselect
    },
    data() {
        return {
            name: null,
            email: null,
            password: null,
            password_confirmation: null,
            phone_number: null,
            avatar: null,
            gender: null,
            dob: null,
            note: null,
            status: 1,
            permissions: [],
            roles: [],
            errors: null,
            check: [],
            role: [],
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
        onSelect(option) {
            console.log(option.name);
            console.log(option);
        },
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
        onchangeFile() {
            this.avatar = this.$refs.file.files[0]
        },
        async sendData() {
            let form = await new FormData()
            await form.append('name', this.name)
            await form.append('email', this.email)
            await form.append('phone_number', this.phone_number)
            await form.append('dob', this.dob)
            await form.append('status', this.status)
            await form.append('note', this.note)
            await form.append('avatar', this.avatar)
            await form.append('gender', this.gender)
            await form.append('password_confirmation', this.password_confirmation)
            await form.append('password', this.password)
            if (this.role.length > 0) {
                const roles = this.role.map(arr => arr.id)
                for (let i = 0; i < roles.length; i++) {
                    await form.append('roles[]', roles[i])
                }
            }
            for (let i = 0; i < this.check.length; i++) {
                await form.append('permissions[]', this.check[i])
            }
            try {
                const data = await api.post('api/admin/users', form, {
                    // 'Content-Type': 'application/json',
                    'Content-Type': 'multipart/form-data',
                    'Authorization': 'Bearer ' + this.auth.access_token
                }, this)
                await alert('success', 'top-center', 'Đã thêm 1 danh mục mới.');
                await this.$router.push('/admin/users');
            } catch (e) {
                if (e) {
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
                const data = await api.get('api/admin/users/create', {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + this.auth.access_token
                })
                this.permissions = await data.data.permissions
                this.roles = await data.data.roles
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

<style src="vue-multiselect/dist/vue-multiselect.css"></style>
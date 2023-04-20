<template>
    <Breadcrumb />

    <div class="row" v-if="data">
        <div class="col-sm-12">
            <!-- Profile -->
            <div class="card bg-success">
                <div class="card-body profile-user-box">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="avatar-lg border border-3 rounded-circle">
                                        <img :src="domain + data.avatar" :alt="data.email"
                                            class="rounded-circle img-thumbnail p-0">
                                    </div>
                                </div>
                                <div class="col">
                                    <div>
                                        <h4 class="mt-1 mb-1 text-white fs-3 fw-bold">{{ data.name }}</h4>
                                        <p class="text-white fs-4 pb-0 mb-1">{{ data.email }}</p>

                                        <ul class="mb-0 list-inline text-light">
                                            <li class="list-inline-item me-3">
                                                <h5 class="mb-1 text-white">$ 25,184</h5>
                                                <p class="mb-0 font-13 text-white-50">Total Revenue</p>
                                            </li>
                                            <li class="list-inline-item">
                                                <h5 class="mb-1 text-white">5482</h5>
                                                <p class="mb-0 font-13 text-white-50">Number of Orders</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="text-center mt-sm-0 mt-3 text-sm-end">
                                <RouterLink :to="'/admin/users/edit/' + data.id" class="btn btn-danger">
                                    <i class="mdi mdi-account-edit me-1"></i> Edit Profile
                                </RouterLink>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import api from '../../../stores/axios'
import { alert, notify, domain } from "../../../config"
import Breadcrumb from '@/components/Layout/Admin/Breadcrumb.vue';

export default {
    components: {
        Breadcrumb,
    },
    data() {
        return {
            id: null,
            data: null,
        }
    },
    props: {
    },
    computed: {
        auth() {
            return this.$store.getters.auth
        },
        domain() {
            return domain;
        }
    },
    methods: {
        async findById(id) {
            try {
                const data = await api.get('api/admin/users/' + id, {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + this.auth.access_token
                })
                this.data = await data.data.data
            } catch (e) {
                console.log(e)
            }
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
        async sendData() {
            let form = await new FormData()
            await form.append('name', this.name)
            await form.append('email', this.email)
            await form.append('phone_number', this.phone_number)
            await form.append('dob', this.dob)
            await form.append('status', this.status)
            await form.append('note', this.note)
            if (this.avatar) {
                await form.append('avatar', this.avatar)
            }
            await form.append('gender', this.gender)
            if (this.password_confirmation && this.password) {
                if (this.password_confirmation.length > 0 && this.password.length > 0) {
                    await form.append('password_confirmation', this.password_confirmation)
                    await form.append('password', this.password)
                }
            }
            await form.append('_method', "PUT")
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
                const data = await api.post('api/admin/users/' + this.id, form, {
                    'Content-Type': 'multipart/form-data',
                    'Authorization': 'Bearer ' + this.auth.access_token
                })
                await alert('success', 'top-center', 'Đã sửa danh mục thành công.');
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
    },
    beforeRouteEnter(to, _from, next) {
        next((vm) => {
            vm.id = to.params.id
        });
    },
    beforeRouteUpdate(to, _from, next) {
        this.id = to.params.id;
        next();
    },
    watch: {
        id() {
            if (this.id) {
                this.findById(this.id);
            } else {
                console.log("id no avaiable")
            }
        }
    },
}
</script>

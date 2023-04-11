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
                            <h3>Edit Role</h3>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Id</label>
                                <input v-if="data" name="id" class="form-control" :value="data.id" disabled />
                            </div>
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
                                    <div v-if="data" v-for="(item, index) in permissions" v-bind:key="index"
                                        class="form-check form-checkbox-success mb-1">
                                        <!-- <template v-for="(check, index) in data.permissions" v-bind:key="index">
                                            <input type="checkbox" class="form-check-input" :value="item.id" v-model="check"
                                                @change="handleCheckboxChange">
                                        </template> -->
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
    data() {
        return {
            id: null,
            data: null,
            name: '',
            permissions: [],
            errors: null,
            check: [],
        }
    },
    components: {
        Breadcrumb,
    },
    computed: {
        auth() {
            return this.$store.getters.auth
        },
    },
    methods: {
        async findById(id) {
            try {
                const data = await api.get('api/admin/roles/' + id, {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + this.auth.access_token
                })
                this.data = await data.data.data
                this.name = this.data.name
                await this.getPermissions();
            } catch (e) {
                console.log(e)
            }
        },
        async sendData() {
            let form = await new FormData()
            await form.append('name', this.name)
            await form.append('_method', "PUT")
            for (let i = 0; i < this.check.length; i++) {
                await form.append('permissions[]', this.check[i])
            }
            try {
                const data = await api.post('api/admin/roles/' + this.id, form, {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + this.auth.access_token
                })
                await alert('success', 'top-center', 'Đã sửa role thành công.');
                await this.$router.push('/admin/roles');
            } catch (e) {
                console.log(e)
                this.errors = e.errors

            }
        },
        async getPermissions() {
            const data = await api.get('api/admin/roles/create', {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + this.auth.access_token
            })
            this.permissions = await data.data.data
            if (this.data) {
                this.check = this.data.permissions.map(obj => obj.id);
            }
        }
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
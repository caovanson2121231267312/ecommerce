<template v-if="id">
    <div class="modal fade" id="editModalTag" tabindex="-1" aria-labelledby="editModalTag" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-success">
                    <h3 class="modal-title h3 text-light">Edit Tag</h3>
                    <button type="button" class="btn-close text-light" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="col-form-label fw-bold text-dark">Id:</label>
                            <input v-if="data" :value="data.id" type="text" class="form-control" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label fw-bold text-dark">Name:</label>
                            <input v-if="data" v-model="name" type="text" class="form-control">
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
            data: null,
            name: '',
            description: '',
            errors: null,
        }
    },
    props: {
        id: {
            type: Number,
        },
        loadData: {
            type: Function,
            required: true,
        }
    },
    computed: {
        auth() {
            return this.$store.getters.auth
        },
    },
    methods: {
        async findById(id) {
            if (!this.auth) {
                alert('danger', 'top-center', 'Bạn cần đăng nhập để tiếp tục.');
                this.$router.push('/login');
                return;
            }
            try {
                const data = await api.get('api/admin/tags/' + id, {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + this.auth.access_token
                })
                this.data = await data.data.data
                this.name = this.data.name
                this.description = this.data.description
            } catch (e) {
                console.log(e)
                try {
                    notify('danger', 'top-center', JSON.stringify(e));
                } catch (ex) {
                    alert('danger', 'top-center', 'Đã có lỗi xảy ra vui lòng thử lại.');
                }
            }
        },
        async sendData() {
            if (!this.auth) {
                alert('danger', 'top-center', 'Bạn cần đăng nhập để tiếp tục.');
                this.$router.push('/login');
                return;
            }
            let form = await new FormData()
            await form.append('name', this.name)
            await form.append('description', this.description)
            await form.append('parent_id', 0)
            await form.append('_method', "PUT")
            try {
                const data = await api.post('api/admin/tags/' + this.id, form, {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + this.auth.access_token
                })
                await alert('success', 'top-center', 'Sửa thành công tags.');
                this.loadData()
                $("#editModalTag").modal('hide');
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
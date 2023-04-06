<template v-if="id">
    <div class="modal fade" id="showModalpermission" tabindex="-1" aria-labelledby="showModalpermission" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-success">
                    <h1 class="modal-title h3 text-light">Show Permission</h1>
                    <button type="button" class="btn-close text-light" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="col-form-label fw-bold text-dark">Name:</label>
                            <input v-if="data" :value="data.name" type="text" class="form-control" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label fw-bold text-dark">Slug:</label>
                            <input v-if="data" :value="data.slug" type="text" class="form-control" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label fw-bold text-dark">Roles:</label>
                            <input v-if="data" :value="data.roles" type="text" class="form-control" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label fw-bold text-dark">Users:</label>
                            <input v-if="data" :value="data.users" type="text" class="form-control" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label fw-bold text-dark">Created at:</label>
                            <input v-if="data" :value="data.created_at" type="text" class="form-control" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label fw-bold text-dark">Updated at:</label>
                            <input v-if="data" :value="data.updated_at" type="text" class="form-control" disabled>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
        }
    },
    props: {
        id: {
            type: Number,
            // required: true
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
                const data = await api.get('api/admin/permissions/' + id, {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + this.auth.access_token
                })
                this.data = await data.data.data
                // this.loadData()
                // $("#showModalpermission").modal('hide');
            } catch (e) {
                console.log(e)
                try {
                    notify('danger', 'top-center', JSON.stringify(e));
                } catch (ex) {
                    alert('danger', 'top-center', 'Đã có lỗi xảy ra vui lòng thử lại.');
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
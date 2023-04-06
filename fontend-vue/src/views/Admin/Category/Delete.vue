<template v-if="id">
    <a href="javascript:void(0);" @click="showModal" class="action-icon text-danger">
        <i class="mdi mdi-delete"></i>
    </a>
</template>

<script>
import api from '../../../stores/axios'
import { alert, notify } from "../../../config"

export default {
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
        showModal() {
            this.$swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    if (this.id) {
                        this.deleteById(this.id)
                    }
                }
            });
        },
        async deleteById(id) {
            try {
                let form = await new FormData()
                await form.append('_method', "DELETE")
                const data = await api.post('api/admin/categories/' + id, form, {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + this.auth.access_token
                })
                await this.loadData()
                await this.$swal(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                )
            } catch (e) {
                await this.$swal(
                    'Cancelled',
                    'Have error, please try again.',
                    'error'
                )
            }
        }
    }
}
</script>
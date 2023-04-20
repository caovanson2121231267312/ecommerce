<template v-if="id">
    <a href="javascript:void(0);" @click="showModal" class="action-icon text-danger">
        <i class="fas fa-user-lock fs-5"></i>
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
        status: {
            type: Number,
        },
        loadData: {
            type: Function,
            required: true,
        }
    },
    data() {
        return {
            text: null,
        }
    },
    computed: {
        auth() {
            return this.$store.getters.auth
        },
    },
    methods: {
        showModal() {
            this.text = this.status == 1 ? "lock this account" : "unlock this account"
            this.$swal({
                title: 'Are you sure?',
                text: this.text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
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
                const data = await api.post('api/admin/users/' + id, form, {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + this.auth.access_token
                })
                await this.loadData()
                await this.$swal(
                    'Done!',
                    this.text,
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
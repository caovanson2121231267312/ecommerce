<template v-if="id">
    <a href="javascript:void(0);" @click="showModal" class="action-icon text-danger">
        <i class="fas fa-times"></i>
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
                text: "Bạn có chắc muốn hủy đơn hàng này!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Có, hủy nó'
            }).then((result) => {
                if (result.isConfirmed) {
                    if (this.id) {
                        this.checkById(this.id)
                    }
                }
            });
        },
        async checkById(id) {
            let form = await new FormData()
            await form.append('_method', "PUT")
            await form.append('status', 4)
            const data = await api.post('api/admin/orders/status/' + id, form, {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + this.auth.access_token
            })
            await this.loadData()
            await this.$swal(
                'Success!',
                'Đã hủy đơn hàng.',
                'success'
            )
        }
    }
}
</script>
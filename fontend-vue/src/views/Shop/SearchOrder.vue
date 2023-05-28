<template>
    <Breadcrumb :items="breadcrumb_arr()" />

    <section class="mt-3">
        <div class="container">
            <div class="row">
                <div id="tra-cuu-don-hang">
                    <div class="box-tra-cuu py-4 px-2">
                        <p class="box-search-title">Kiểm tra thông tin đơn hàng <span><br> &amp; tình trạng vận
                                chuyển</span></p>
                        <form
                            class="box-search-info is-flex is-flex-direction-column is-justify-content-center is-align-items-center">
                            <div class="field">
                                <div class="box-search-item">
                                    <input maxlength="10" v-model="phone" class="box-search-item"
                                        placeholder="Số điện thoại (bắt buộc)">
                                </div>
                            </div>
                            <div class="field">
                                <div class="box-search-item">
                                    <input v-model="email" placeholder="Hoặc Email của bạn" class="box-search-item">
                                </div>
                            </div>
                            <button type="button" @click="searchOrder" class="mt-3 btn button button__check-order">
                                Kiểm tra
                            </button>
                            <div class="text-center my-2">
                                hoặc
                            </div>
                            <RouterLink to="/login" class="btn smember-link button__link-to-auth">
                                Đăng nhập để tra cứu thuận tiện hơn
                            </RouterLink>
                        </form>
                        <div class="bg-order-check"></div>
                        <div class="bg-image">
                            <img :src="images.ship" alt="cps-icon" />
                        </div>
                        <div class="cps-order-container"><!----></div>
                    </div>
                </div>

                <div class="col-12" v-if="data.length > 0">
                    <div class="my-5">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col" class="fw-bold">Mã hóa đơn</th>
                                    <th scope="col">Khách hàng</th>
                                    <th scope="col">Thông tin đơn</th>
                                    <th scope="col">Sản phẩm</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in data" v-bind:key="index">
                                    <th>{{ item.ref }}</th>
                                    <td>
                                        <div>
                                            <div>
                                                <span>Họ và tên: </span>
                                                <span>{{ item.name }}</span>
                                            </div>
                                            <div>
                                                <span>Số điện thoại: </span>
                                                <span>{{ item.phone }}</span>
                                            </div>
                                            <div>
                                                <span>Email: </span>
                                                <span>{{ item.email }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <div>
                                                <span>Tổng tiền: </span>
                                                <span>{{ item.sale_price }}</span>
                                            </div>
                                            <div>
                                                <span>Tổng số lượng: </span>
                                                <span>{{ item.quantity }}</span>
                                            </div>
                                            <div>
                                                <span>Tạo lúc: </span>
                                                <span>{{ item.created_at }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <div>
                                                <ul>
                                                    <li v-for="(value, i) in item.products" v-bind:key="i">
                                                        {{ value.name }}
                                                        <span class="text-danger">
                                                            ({{ value.pivot_quantity }} * {{ value.pivot_price }})
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import Breadcrumb from "../../components/Breadcrumb.vue";
import images from "@/assets/images"
import api from "@/stores/axios"

export default {
    data() {
        return {
            data: [],
            images: images,
            phone: '',
            email: '',
        }
    },
    components: {
        Breadcrumb,
    },
    methods: {
        breadcrumb_arr() {
            var arr = [];
            arr.push({
                'name': 'Tra cứu đơn hàng',
                'slug': "/search-order"
            });
            return arr;
        },
        async searchOrder() {
            let form = await new FormData()
            await form.append('phone', this.phone)
            await form.append('email', this.email)
            api.post('api/search-order', form, {
                'Content-Type': 'application/json',
                // 'Authorization': 'Bearer ' + JSON.parse(localStorage.getItem('auth')).access_token
            }, this)
                .then(response => {
                    if (response.data.data.length == 0) {
                        this.$swal(
                            'Cancelled',
                            'Thông tin bạn nhập chưa đầy đủ hoặc không chính xác, vui lòng thử lại.',
                            'warning'
                        )
                    } else {
                        this.data = response.data.data;
                    }
                })
        },
    },

}
</script>
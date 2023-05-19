<template>
    <section class="mt-3">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <!-- Checkout Steps -->
                            <ul class="nav nav-pills bg-nav-pills nav-justified mb-3" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a href="#billing-information" data-bs-toggle="tab" aria-expanded="false"
                                        class="nav-link rounded-0 active" aria-selected="true" role="tab">
                                        <i class="mdi mdi-account-circle font-18"></i>
                                        <span class="d-none d-lg-block">Billing Info</span>
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a href="#payment-information" data-bs-toggle="tab" aria-expanded="false"
                                        class="nav-link rounded-0" aria-selected="false" role="tab" tabindex="-1">
                                        <i class="mdi mdi-cash-multiple font-18"></i>
                                        <span class="d-none d-lg-block">Payment Info</span>
                                    </a>
                                </li>
                            </ul>

                            <!-- Steps Information -->
                            <div class="tab-content">

                                <!-- Billing Content-->
                                <div class="tab-pane active show" id="billing-information" role="tabpanel">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <h4 class="mt-2">Billing information</h4>

                                            <p class="text-muted mb-4">Fill the form below in order to
                                                send you the order's invoice.</p>

                                            <form>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="billing-first-name" class="form-label">First
                                                                Name</label>
                                                            <input class="form-control" type="text" v-model="firstname"
                                                                placeholder="Enter your first name" id="billing-first-name">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="billing-last-name" class="form-label">Last
                                                                Name</label>
                                                            <input class="form-control" type="text" v-model="lastname"
                                                                placeholder="Enter your last name" id="billing-last-name">
                                                        </div>
                                                    </div>
                                                </div> <!-- end row -->
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="billing-email-address" class="form-label">Email
                                                                Address
                                                                <span class="text-danger">*</span></label>
                                                            <input class="form-control" type="email" v-model="email"
                                                                placeholder="Enter your email" id="billing-email-address">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="billing-phone" class="form-label">Phone <span
                                                                    class="text-danger">*</span></label>
                                                            <input class="form-control" type="text" v-model="phone"
                                                                placeholder="(xx) xxx xxxx xxx" id="billing-phone">
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label for="billing-address" class="form-label">Address</label>
                                                            <input class="form-control" type="text" v-model="address"
                                                                placeholder="Enter full address" id="billing-address">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <div class="form-group">
                                                                <label>Chọn ngôn ngữ giao diện thanh toán:</label>
                                                                <div>
                                                                    <input type="radio" id="language" v-model="language"
                                                                        @change="handleLanguageChange" name="language"
                                                                        value="vn">
                                                                    <label class="me-5 ms-1" for="language">Tiếng
                                                                        việt</label>
                                                                    <input type="radio" id="language" name="language"
                                                                        v-model="language" @change="handleLanguageChange"
                                                                        value="en">
                                                                    <label class="ms-1" for="language">Tiếng anh</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="mb-3 mt-3">
                                                            <label for="example-textarea" class="form-label">
                                                                Ghi chú:
                                                            </label>
                                                            <textarea v-model="note" class="form-control"
                                                                id="example-textarea" rows="3"
                                                                placeholder="Write some note.."></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-4">
                                                    <div class="col-sm-6">
                                                        <RouterLink to="/cart"
                                                            class="btn text-muted d-none d-sm-inline-block btn-link fw-semibold">
                                                            <i class="mdi mdi-arrow-left"></i> Quay lại giỏ hàng
                                                        </RouterLink>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="text-sm-end">
                                                            <button @click="openNewWindow" class="btn btn-danger">
                                                                <i class="mdi mdi-cash-multiple me-1"></i>
                                                                Xác nhận
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="border p-3 mt-4 mt-lg-0 rounded">
                                                <h4 class="header-title mb-3">Đơn hàng</h4>

                                                <div class="table-responsive">
                                                    <table class="table mb-0">
                                                        <tbody>
                                                            <tr v-for="(item, index) in items" v-bind:key="index">
                                                                <td>
                                                                    <img :src="image(item.images)" alt="contact-img"
                                                                        title="contact-img" class="rounded me-2" width="48">
                                                                    <div class="d-inline-block">
                                                                        <small>{{ item.count }} x
                                                                            {{ formatCurrency(saleProduct(item.price,
                                                                                item.sale)) }}</small>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <p class="m-0 d-inline-block align-middle">
                                                                        <a href="" class="text-body">
                                                                            {{ item.name }}
                                                                        </a>
                                                                        <br>
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                            <tr class="text-end">
                                                                <td>
                                                                    <h6 class="m-0">Sub Total:</h6>
                                                                </td>
                                                                <td class="text-end">
                                                                    {{ formatCurrency(total) }} VND
                                                                </td>
                                                            </tr>
                                                            <tr class="text-end">
                                                                <td>
                                                                    <h6 class="m-0">Shipping:</h6>
                                                                </td>
                                                                <td class="text-end">
                                                                    FREE
                                                                </td>
                                                            </tr>
                                                            <tr class="text-end">
                                                                <td>
                                                                    <h5 class="m-0">Total:</h5>
                                                                </td>
                                                                <td class="text-end fw-semibold">
                                                                    {{ formatCurrency(total) }} VND
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!-- end table-responsive -->
                                            </div> <!-- end .border-->

                                        </div> <!-- end col -->
                                    </div> <!-- end row-->
                                </div>
                                <!-- End Billing Information Content-->

                                <!-- Payment Content-->
                                <div class="tab-pane" id="payment-information" role="tabpanel">
                                    <div class="row">

                                        <div class="col-lg-8">
                                            <h4 class="mt-2">Payment Selection</h4>

                                            <p class="text-muted mb-4">Fill the form below in order to
                                                send you the order's invoice.</p>

                                            <!-- Pay with Paypal box-->
                                            <div class="border p-3 mb-3 rounded">
                                                <div class="row">
                                                    <div class="col-sm-8">
                                                        <div class="form-check">
                                                            <input type="radio" v-model="payment"
                                                                @change="handlePaymentChange" value="0"
                                                                id="BillingOptRadio2" name="billingOptions"
                                                                class="form-check-input">
                                                            <label class="form-check-label font-16 fw-bold"
                                                                for="BillingOptRadio2">Thanh toán với Paypal</label>
                                                        </div>
                                                        <p class="mb-0 ps-3 pt-1">
                                                            Bạn sẽ được chuyển hướng đến trang web PayPal để hoàn tất giao
                                                            dịch mua của mình một cách an toàn..</p>
                                                    </div>
                                                    <div class="col-sm-4 text-sm-end mt-3 mt-sm-0">
                                                        <img :src="images.paypal" height="25" alt="paypal-img">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end Pay with Paypal box-->

                                            <!-- Credit/Debit Card box-->
                                            <div class="border p-3 mb-3 rounded">
                                                <div class="row">
                                                    <div class="col-sm-8">
                                                        <div class="form-check">
                                                            <input type="radio" v-model="payment"
                                                                @change="handlePaymentChange" value="INTCARD"
                                                                id="BillingOptRadio1" name="billingOptions"
                                                                class="form-check-input">
                                                            <label class="form-check-label font-16 fw-bold"
                                                                for="BillingOptRadio1">Thanh toán qua thẻ quốc tế</label>
                                                        </div>
                                                        <p class="mb-0 ps-3 pt-1">
                                                            Hỗ trợ Mastercard, Visa, Discover và Stripe.
                                                        </p>
                                                    </div>
                                                    <div class="col-sm-4 text-sm-end mt-3 mt-sm-0">
                                                        <img :src="images.master" height="24" alt="master-card-img">
                                                        <img :src="images.discover" height="24" alt="discover-card-img">
                                                        <img :src="images.visa" height="24" alt="visa-card-img">
                                                        <img :src="images.stripe" height="24" alt="stripe-card-img">
                                                    </div>
                                                </div> <!-- end row -->

                                            </div>

                                            <div class="border p-3 mb-3 rounded">
                                                <div class="row">
                                                    <div class="col-sm-8">
                                                        <div class="form-check">
                                                            <input type="radio" v-model="payment"
                                                                @change="handlePaymentChange" value="VNBANK"
                                                                id="BillingOptRadio4" name="billingOptions"
                                                                class="form-check-input">
                                                            <label class="form-check-label font-16 fw-bold"
                                                                for="BillingOptRadio4">Thanh toán bằng thẻ ngân hàng/ Tài
                                                                khoản nội địa</label>
                                                        </div>
                                                        <p class="mb-0 ps-3 pt-1">
                                                            Hỗ trợ các loại thẻ ngân hàng trong nước để thanh toán
                                                        </p>
                                                    </div>
                                                    <div class="col-sm-4 text-sm-end mt-3 mt-sm-0">
                                                        <img :src="images.vietcombank" height="44" alt="master-card-img">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="border p-3 mb-3 rounded">
                                                <div class="row">
                                                    <div class="col-sm-8">
                                                        <div class="form-check">
                                                            <input type="radio" v-model="payment"
                                                                @change="handlePaymentChange" value="" id="BillingOptRadio5"
                                                                name="billingOptions" class="form-check-input">
                                                            <label class="form-check-label font-16 fw-bold"
                                                                for="BillingOptRadio4">Thanh toán VNPAYQR</label>
                                                        </div>
                                                        <p class="mb-0 ps-3 pt-1">
                                                            Quét mã QR để thanh toán
                                                        </p>
                                                    </div>
                                                    <div class="col-sm-4 text-sm-end mt-3 mt-sm-0">
                                                        <img :src="images.qr" height="44" alt="master-card-img">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-4">
                                                <div class="col-sm-6">
                                                    <RouterLink to="/cart"
                                                        class="btn text-muted d-none d-sm-inline-block btn-link fw-semibold">
                                                        <i class="mdi mdi-arrow-left"></i> Quay lại giỏ hàng
                                                    </RouterLink>
                                                </div> <!-- end col -->
                                                <div class="col-sm-6">
                                                    <div class="text-sm-end">
                                                        <button @click="openNewWindow" class="btn btn-danger">
                                                            <i class="mdi mdi-cash-multiple me-1"></i>
                                                            Xác nhận
                                                        </button>
                                                    </div>
                                                </div> <!-- end col -->
                                            </div> <!-- end row-->

                                        </div> <!-- end col -->

                                        <div class="col-lg-4">
                                            <div class="border p-3 mt-4 mt-lg-0 rounded">
                                                <h4 class="header-title mb-3">Đơn hàng</h4>

                                                <div class="table-responsive">
                                                    <table class="table mb-0">
                                                        <tbody>
                                                            <tr v-for="(item, index) in items" v-bind:key="index">
                                                                <td>
                                                                    <img :src="image(item.images)" alt="contact-img"
                                                                        title="contact-img" class="rounded me-2" width="48">
                                                                    <div class="d-inline-block">
                                                                        <small>{{ item.count }} x
                                                                            {{ formatCurrency(saleProduct(item.price,
                                                                                item.sale)) }}</small>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <p class="m-0 d-inline-block align-middle">
                                                                        <a href="" class="text-body">
                                                                            {{ item.name }}
                                                                        </a>
                                                                        <br>
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                            <tr class="text-end">
                                                                <td>
                                                                    <h6 class="m-0">Sub Total:</h6>
                                                                </td>
                                                                <td class="text-end">
                                                                    {{ formatCurrency(total) }} VND
                                                                </td>
                                                            </tr>
                                                            <tr class="text-end">
                                                                <td>
                                                                    <h6 class="m-0">Shipping:</h6>
                                                                </td>
                                                                <td class="text-end">
                                                                    FREE
                                                                </td>
                                                            </tr>
                                                            <tr class="text-end">
                                                                <td>
                                                                    <h5 class="m-0">Total:</h5>
                                                                </td>
                                                                <td class="text-end fw-semibold">
                                                                    {{ formatCurrency(total) }} VND
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!-- end table-responsive -->
                                            </div> <!-- end .border-->

                                        </div> <!-- end col -->
                                    </div> <!-- end row-->
                                </div>
                                <!-- End Payment Information Content-->

                            </div> <!-- end tab content-->

                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col -->
            </div>
        </div>
    </section>
</template>

<script>
import { getProductInCart, mergeProductInCart, firstImage } from "../../config"
import api from "../../stores/axios";
import images from "@/assets/images/index.js";
import {
    RouterLink
} from 'vue-router'

export default {
    data() {
        return {
            images: images,
            product: null,
            message: null,
            total: 0,
            note: '',
            firstname: '',
            lastname: '',
            email: '',
            phone: '',
            address: '',
            quantity: '',
            note: '',
            payment: 'INTCARD',
            language: 'vn',
        }
    },
    computed: {
        cart() {
            return this.$store.getters.cart
        },
        productInCart() {
            return getProductInCart(this.cart);
        },
        items() {
            if (!this.product) return [];
            return mergeProductInCart(this.productInCart, this.product);
        },
        auth() {
            return this.$store.getters.auth
        },
    },
    mounted() {
        const loadData = async () => {
            await this.$store.dispatch('isLoading', true)
            await api.post("api/carts", { "cart": this.productInCart }, {
                'Content-Type': 'multipart/form-data'
            }, this).then(response => {
                console.log(response)
                this.product = response.data.data
            });
            console.log(this.product)
            await this.$store.dispatch('isLoading', false)
            await this.items.map(x => this.total += x.count * this.saleProduct(x.price, x.sale))
        }
        loadData();
        console.log(this.items)
    },
    methods: {
        handleLanguageChange(value) {
            this.payment = value
        },
        handlePaymentChange(value) {
            const parsedValue = parseInt(value, 10);
            if (!isNaN(parsedValue)) {
                this.payment = parseInt(parsedValue)
            }
        },
        formatCurrency(value) {
            if (value) {
                return parseInt(value).toLocaleString('de-DE')
            }
            return null
        },
        saleProduct(price, sale) {
            return price - (price * sale) / 100
        },
        image(data) {
            return firstImage(data);
        },
        async openNewWindow(event) {
            event.preventDefault();
            const price = this.items.reduce(
                (total, product) => total + product.price * product.count,
                0
            );
            const quantity = this.items.reduce(
                (total, product) => total + product.count,
                0
            );

            let form = await new FormData()
            await form.append('firstname', this.firstname)
            await form.append('lastname', this.lastname)
            await form.append('email', this.email)
            await form.append('phone', this.phone)
            await form.append('address', this.address)
            await form.append('note', this.note)
            await form.append('bankCode', this.payment)
            await form.append('amount', this.total)
            await form.append('price', price)
            await form.append('quantity', quantity)
            await form.append('language', this.language)
            await form.append('products', JSON.stringify(this.items))

            const data = await api.post('api/create_payment', form, {
                'Content-Type': 'multipart/form-data',
                'Authorization': 'Bearer ' + this.auth.access_token
            }, this)
            console.log(data)
            if (data.status == 200) {
                const url = data.data.url
                const width = 1000;
                const height = 600;
                const left = (window.screen.width / 2) - (width / 2);
                const top = (window.screen.height / 2) - (height / 2);
                const newWindow = window.open(url, '_blank', `width=${width},height=${height},left=${left},top=${top}`);
                window.addEventListener('message', event => {
                    if (event.origin !== 'http://localhost:5173') return;
                    this.message = event.data;
                    const url = new URL(this.message);
                    const searchParams = url.searchParams;

                    const vnp_ResponseCode = searchParams.get("vnp_ResponseCode");
                    const vnp_TxnRef = searchParams.get("vnp_TxnRef");
                    if (vnp_ResponseCode == "00") {
                        this.$swal(
                            'Đặt hàng!',
                            'Bạn đã thanh toán thành công với mã đơn hàng: ' + vnp_TxnRef + ', tư vấn viên sẽ liên hệ lại bạn sớm nhất để xác nhận đơn hàng.',
                            'success'
                        )
                        let form = new FormData()
                        form.append('status_payment', 1)
                        const data = api.post('api/order/' + vnp_TxnRef, form, {
                            'Content-Type': 'multipart/form-data',
                            'Authorization': 'Bearer ' + this.auth.access_token
                        }, this)
                    } else {
                        this.$swal(
                            'Đặt hàng!',
                            'Giao dịch thất bại, bạn vui lòng thử lại hoặc liên hệ 038912038 để tư vấn',
                            'error'
                        )
                        let form = new FormData()
                        form.append('status_payment', 2)
                        const data = api.post('api/order/' + vnp_TxnRef, form, {
                            'Content-Type': 'multipart/form-data',
                            'Authorization': 'Bearer ' + this.auth.access_token
                        }, this)
                    }
                    newWindow.close();
                });
            }
        }
    }
}
</script>
<template>
    <Breadcrumb />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-5">
                            <RouterLink to="/admin/orders/create" class="btn btn-danger mb-2">
                                <i class="mdi mdi-plus-circle me-2"></i> Add order
                            </RouterLink>
                        </div>
                        <div class="col-sm-7">
                            <div class="text-sm-end">
                                <button type="button" class="btn btn-success mb-2 me-1"><i
                                        class="mdi mdi-cog-outline"></i></button>
                                <button type="button" class="btn btn-light mb-2 me-1">Import</button>
                                <button type="button" class="btn btn-light mb-2">Export</button>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="">
                                <label class="form-label d-inline-flex">
                                    <span class="d-flex align-items-center">Display</span>
                                    <select class="form-select form-select-sm ms-1 me-1" @change="onPageSize($event)">
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="20">50</option>
                                        <option value="100">100</option>
                                        <option value="1000">1000</option>
                                    </select>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div>
                                <label class="d-inline-flex float-end">
                                    <span class="d-flex align-items-center me-2">Search:</span>
                                    <input type="search" class="form-control form-control-sm" v-debounce:100="onSearch" />
                                </label>
                            </div>
                        </div>
                    </div>

                    <table class="table table-hover table-striped">
                        <thead class="table-light">
                            <tr>
                                <th class="sorting_disabled dt-checkboxes-cell dt-checkboxes-select-all" rowspan="1"
                                    colspan="1" data-col="0" aria-label="&amp;nbsp;">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input dt-checkboxes">
                                        <label class="form-check-label">&nbsp;</label>
                                    </div>
                                </th>
                                <th @click="softBy('name')">
                                    <span class="fs-5 fw-bold text-dark me-2">User</span>
                                    <span v-if="config.order_by == 'name'">
                                        <i v-if="config.mode == 'desc'" class="fas fa-sort-down"></i>
                                        <i v-else class="fas fa-sort-up"></i>
                                    </span>
                                    <span v-else>
                                        <i class="fas fa-sort"></i>
                                    </span>
                                </th>
                                <th @click="softBy('quantity')">
                                    <span class="fs-5 fw-bold text-dark me-2">Information</span>
                                    <span v-if="config.order_by == 'quantity'">
                                        <i v-if="config.mode == 'desc'" class="fas fa-sort-down"></i>
                                        <i v-else class="fas fa-sort-up"></i>
                                    </span>
                                    <span v-else>
                                        <i class="fas fa-sort"></i>
                                    </span>
                                </th>
                                <th @click="softBy('status_payment')">
                                    <span class="fs-5 fw-bold text-dark me-2">Payment Status</span>
                                    <span v-if="config.order_by == 'status_payment'">
                                        <i v-if="config.mode == 'desc'" class="fas fa-sort-down"></i>
                                        <i v-else class="fas fa-sort-up"></i>
                                    </span>
                                    <span v-else>
                                        <i class="fas fa-sort"></i>
                                    </span>
                                </th>
                                <th @click="softBy('card')">
                                    <span class="fs-5 fw-bold text-dark me-2">Payment Method</span>
                                    <span v-if="config.order_by == 'card'">
                                        <i v-if="config.mode == 'desc'" class="fas fa-sort-down"></i>
                                        <i v-else class="fas fa-sort-up"></i>
                                    </span>
                                    <span v-else>
                                        <i class="fas fa-sort"></i>
                                    </span>
                                </th>
                                <th @click="softBy('status')">
                                    <span class="fs-5 fw-bold text-dark me-2">Order Status</span>
                                    <span v-if="config.order_by == 'status'">
                                        <i v-if="config.mode == 'desc'" class="fas fa-sort-down"></i>
                                        <i v-else class="fas fa-sort-up"></i>
                                    </span>
                                    <span v-else>
                                        <i class="fas fa-sort"></i>
                                    </span>
                                </th>
                                <th>
                                    <span class="fs-5 fw-bold text-dark">Action</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="order in orders" :key="order.id">
                                <td class="dt-checkboxes-cell dtr-control" style="outline: none;">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input dt-checkboxes">
                                        <label class="form-check-label">&nbsp;</label>
                                    </div>
                                </td>
                                <td class="sorting">
                                    <div class="d-flex">
                                        <div>
                                            <div>
                                                <span class="text-dark fw-bold">Name: </span>
                                                <span>{{ order.name }}</span>
                                            </div>
                                            <div>
                                                <span class="text-dark fw-bold">Email: </span>
                                                <span>{{ order.email }}</span>
                                            </div>
                                            <div>
                                                <span class="text-dark fw-bold">Phone: </span>
                                                <span>{{ order.phone }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="sorting">
                                    <div class="d-flex">
                                        <div>
                                            <div>
                                                <span class="text-dark fw-bold">Ref: </span>
                                                <span>{{ order.ref }}</span>
                                            </div>
                                            <div>
                                                <span class="text-dark fw-bold">Quantity: </span>
                                                <span>{{ order.quantity }}</span>
                                            </div>
                                            <div>
                                                <span class="text-dark fw-bold">Price: </span>
                                                <span>{{ order.price }}</span>
                                            </div>
                                            <div>
                                                <span class="text-dark fw-bold">Sale price: </span>
                                                <span>{{ order.sale_price }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="sorting position-relative">
                                    <div class="translate-middle">
                                        <span v-if="order.status_payment == 0" class="badge badge-info-lighten">
                                            <i class="mdi mdi-cash"></i> {{ order.status_payment_description }}
                                        </span>
                                        <span v-else-if="order.status_payment == 1" class="badge badge-success-lighten">
                                            <i class="mdi mdi-bitcoin"></i> {{ order.status_payment_description }}
                                        </span>
                                        <span v-else class="badge badge-danger-lighten">
                                            <i class="mdi mdi-cancel"></i> {{ order.status_payment_description }}
                                        </span>
                                    </div>
                                </td>
                                <td class="sorting position-relative">
                                    <span class="translate-middle">{{ order.card }}</span>
                                </td>
                                <td class="sorting position-relative">
                                    <div class="translate-middle">
                                        <span v-if="order.status == 0" class="badge rounded-pill bg-warning">
                                            {{ order.status_order_description }}
                                        </span>
                                        <span v-if="order.status == 1" class="badge rounded-pill bg-info">
                                            {{ order.status_order_description }}
                                        </span>
                                        <span v-if="order.status == 2" class="badge rounded-pill bg-primary">
                                            {{ order.status_order_description }}
                                        </span>
                                        <span v-if="order.status == 3" class="badge rounded-pill bg-success">
                                            {{ order.status_order_description }}
                                        </span>
                                        <span v-if="order.status == 4" class="badge rounded-pill bg-danger">
                                            {{ order.status_order_description }}
                                        </span>
                                    </div>
                                </td>
                                <td class="table-action">
                                    <RouterLink :to="'/admin/orders/show/' + order.id" class="action-icon text-info">
                                        <i class="mdi mdi-eye"></i>
                                    </RouterLink>
                                    <RouterLink :to="'/admin/orders/edit/' + order.id" class="action-icon text-success">
                                        <i class="mdi mdi-square-edit-outline"></i>
                                    </RouterLink>
                                    <i class="fas fa-check"></i>
                                    <i class="fas fa-times"></i>
                                </td>
                            </tr>
                            <tr v-if="!orders.length">
                                <td colspan="7" class="text-center">No orders found</td>
                            </tr>
                        </tbody>
                    </table>

                    <Pagination :changePage="changePage" v-if="Object.keys(meta).length !== 0" :meta="meta" />

                </div>
            </div>

        </div>
    </div>
</template>
  
<script>
import Breadcrumb from '@/components/Layout/Admin/Breadcrumb.vue';
import Pagination from '@/components/Page/Pagination.vue';
import { convertPage, domain } from '../../../config';

import axios from 'axios';
import api from '../../../stores/axios';

export default {
    components: {
        Breadcrumb,
        Pagination,
    },
    data() {
        return {
            orders: [],
            status_orders: [],
            status_payments: [],
            meta: {},
            config: {
                page: 1,
                search: null,
                key: null,
                order_by: null,
                mode: 'desc',
            },
            id: null,
        };
    },
    computed: {
        domain() {
            return domain;
        }
    },
    methods: {
        changePage(pageNumber) {
            console.log(pageNumber)
            if (pageNumber >= 1 && pageNumber <= this.meta.last_page) {
                this.config.page = pageNumber
                this.loadData();
            }
        },
        onSearch(val, e) {
            if (val.length > 1) {
                this.config.key = val;
                this.config.search = "name";
            } else {
                this.config.key = null;
            }
            this.loadData();
        },
        onPageSize(event) {
            this.config.page_size = event.target.value;
            this.loadData();
        },
        softBy(name) {
            this.config.order_by = name;
            this.config.mode = this.config.mode === 'asc' ? 'desc' : 'asc';
            this.loadData();
        },
        loadData() {
            let url = "api/admin/orders?page=" + this.config.page
            if (this.config.key && this.config.search) {
                url += "&key=" + this.config.key + "&search=" + this.config.search;
            }
            if (this.config.page_size) {
                url += "&page_size=" + this.config.page_size;
            }
            if (this.config.order_by) {
                url += "&order_by=" + this.config.order_by + "&mode=" + this.config.mode;
            }
            api.get(url, {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + JSON.parse(localStorage.getItem('auth')).access_token
            }, this)
                .then(response => {
                    this.orders = response.data.data;
                    this.meta = convertPage(response.data.meta);
                })

            api.get('api/status_order', {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + JSON.parse(localStorage.getItem('auth')).access_token
            }, this)
                .then(response => {
                    this.status_orders = response.data.status_order;
                    this.status_payments = response.data.status_payment;
                })
        },
        showorder(id) {
            this.id = id
            $("#showModalorder").modal('show');
        },
    },
    mounted() {
        this.loadData();
    },
};
</script>
  
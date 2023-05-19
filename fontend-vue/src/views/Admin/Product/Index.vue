<template>
    <Breadcrumb />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-5">
                            <RouterLink to="/admin/products/create" class="btn btn-danger mb-2">
                                <i class="mdi mdi-plus-circle me-2"></i> Add Product
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
                                        <option value="50">50</option>
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
                                    <input type="search" class="form-control form-control-sm" v-debounce:200="onSearch" />
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
                                <th class="" @click="softBy('name')">
                                    <span class="fs-5 fw-bold text-dark me-2">Name</span>
                                    <span v-if="config.order_by == 'name'">
                                        <i v-if="config.mode == 'desc'" class="fas fa-sort-down"></i>
                                        <i v-else class="fas fa-sort-up"></i>
                                    </span>
                                    <span v-else>
                                        <i class="fas fa-sort"></i>
                                    </span>
                                </th>
                                <th @click="softBy('brands_count')">
                                    <span class="fs-5 fw-bold text-dark me-2">Brands</span>
                                    <span v-if="config.order_by == 'brands_count'">
                                        <i v-if="config.mode == 'desc'" class="fas fa-sort-down"></i>
                                        <i v-else class="fas fa-sort-up"></i>
                                    </span>
                                    <span v-else>
                                        <i class="fas fa-sort"></i>
                                    </span>
                                </th>
                                <th @click="softBy('products_count')">
                                    <span class="fs-5 fw-bold text-dark me-2">Products</span>
                                    <span v-if="config.order_by == 'products_count'">
                                        <i v-if="config.mode == 'desc'" class="fas fa-sort-down"></i>
                                        <i v-else class="fas fa-sort-up"></i>
                                    </span>
                                    <span v-else>
                                        <i class="fas fa-sort"></i>
                                    </span>
                                </th>
                                <th @click="softBy('status')">
                                    <span class="fs-5 fw-bold text-dark me-2">Preview</span>
                                    <span v-if="config.order_by == 'status'">
                                        <i v-if="config.mode == 'desc'" class="fas fa-sort-down"></i>
                                        <i v-else class="fas fa-sort-up"></i>
                                    </span>
                                    <span v-else>
                                        <i class="fas fa-sort"></i>
                                    </span>
                                </th>
                                <th @click="softBy('updated_at')">
                                    <span class="fs-5 fw-bold text-dark me-2">Created at</span>
                                    <span v-if="config.order_by == 'updated_at'">
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
                            <!-- <template> -->
                            <tr v-for="(value, index) in products" v-bind:key="index">
                                <Row :value="value" />
                            </tr>
                            <!-- </template> -->
                            <tr v-if="!products.length">
                                <td colspan="7" class="text-center">No values found</td>
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
import Stars from '@/components/Rate/Stars.vue';
import Image from './Image.vue';
import Row from './Row.vue';
import { convertPage, firstImage, formatCurrency } from '../../../config';
import axios from 'axios';
import api from "../../../stores/axios"

export default {
    components: {
        Breadcrumb,
        Pagination,
        Stars,
        Image,
        Row
    },
    data() {
        return {
            products: [],
            meta: {},
            config: {
                page: 1,
                search: null,
                key: null,
                order_by: null,
                mode: 'asc',
            },
            items: []
        };
    },
    computed: {

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
            let url = "api/admin/products?page=" + this.config.page
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
                    this.products = response.data.data;
                    this.meta = convertPage(response.data.meta);
                    console.log(response)
                })
                .catch(error => {
                    console.log(error);
                });
        }
    },
    mounted() {
        this.loadData();
    },
};
</script>
  
<template>
    <Breadcrumb />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-5">
                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#createModalTag"
                                class="btn btn-danger mb-2"><i class="mdi mdi-plus-circle me-2"></i> Add Tag</a>
                            <Create :loadData="loadData" />
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
                                <th @click="softBy('id')">
                                    <span class="fs-5 fw-bold text-dark me-2">ID</span>
                                    <span v-if="config.order_by == 'id'">
                                        <i v-if="config.mode == 'desc'" class="fas fa-sort-down"></i>
                                        <i v-else class="fas fa-sort-up"></i>
                                    </span>
                                    <span v-else>
                                        <i class="fas fa-sort"></i>
                                    </span>
                                </th>
                                <th @click="softBy('name')">
                                    <span class="fs-5 fw-bold text-dark me-2">Name</span>
                                    <span v-if="config.order_by == 'name'">
                                        <i v-if="config.mode == 'desc'" class="fas fa-sort-down"></i>
                                        <i v-else class="fas fa-sort-up"></i>
                                    </span>
                                    <span v-else>
                                        <i class="fas fa-sort"></i>
                                    </span>
                                </th>
                                <!-- <th @click="softBy('brands_count')">
                                    <span class="fs-5 fw-bold text-dark me-2">Brands</span>
                                    <span v-if="config.order_by == 'brands_count'">
                                        <i v-if="config.mode == 'desc'" class="fas fa-sort-down"></i>
                                        <i v-else class="fas fa-sort-up"></i>
                                    </span>
                                    <span v-else>
                                        <i class="fas fa-sort"></i>
                                    </span>
                                </th> -->
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
                                <th @click="softBy('created_at')">
                                    <span class="fs-5 fw-bold text-dark me-2">Timestamp</span>
                                    <span v-if="config.order_by == 'created_at'">
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
                            <tr v-for="Tag in tags" :key="Tag.id">
                                <td class="dt-checkboxes-cell dtr-control" style="outline: none;">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input dt-checkboxes">
                                        <label class="form-check-label">&nbsp;</label>
                                    </div>
                                </td>
                                <td>{{ Tag.id }}</td>
                                <td class="sorting">{{ Tag.name }}</td>
                                <!-- <td class="sorting">{{ Tag.brands }}</td> -->
                                <td class="sorting">{{ Tag.products }}</td>
                                <td>
                                    <div>
                                        <span class="fw-bold">Created at: </span>
                                        <span>{{ Tag.created_at }}</span>
                                    </div>
                                    <div>
                                        <span class="fw-bold">Updated at: </span>
                                        <span>{{ Tag.updated_at }}</span>
                                    </div>
                                </td>
                                <td class="table-action">
                                    <a href="javascript:void(0);" @click="showTag(Tag.id)" class="action-icon text-info">
                                        <i class="mdi mdi-eye"></i>
                                    </a>
                                    <a href="javascript:void(0);" @click="editTag(Tag.id)" class="action-icon text-success">
                                        <i class="mdi mdi-square-edit-outline"></i>
                                    </a>
                                    <Delete :id="Tag.id" :load-data="loadData" />
                                </td>
                            </tr>
                            <tr v-if="!tags.length">
                                <td colspan="7" class="text-center">No Tags found</td>
                            </tr>
                        </tbody>
                    </table>

                    <Pagination :changePage="changePage" v-if="Object.keys(meta).length !== 0" :meta="meta" />

                    <Show :id="id" :load-data="loadData" />
                    <Edit :id="id" :load-data="loadData" />
                </div>
            </div>

        </div>
    </div>
</template>
  
<script>
import Breadcrumb from '@/components/Layout/Admin/Breadcrumb.vue';
import Pagination from '@/components/Page/Pagination.vue';
import { convertPage } from '../../../config';
import Create from './Create.vue';
import Show from './Show.vue';
import Edit from './Edit.vue';
import Delete from './Delete.vue';

import axios from 'axios';

export default {
    components: {
        Breadcrumb,
        Pagination,
        Create,
        Show,
        Edit,
        Delete,
    },
    data() {
        return {
            tags: [],
            meta: {},
            config: {
                page: 1,
                search: null,
                key: null,
                order_by: null,
                mode: 'asc',
            },
            id: null,
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
            let url = "http://127.0.0.1:8000/api/admin/tags?order_by=id&mode=asc&page=" + this.config.page
            if (this.config.key && this.config.search) {
                url += "&key=" + this.config.key + "&search=" + this.config.search;
            }
            if (this.config.page_size) {
                url += "&page_size=" + this.config.page_size;
            }
            if (this.config.order_by) {
                url += "&order_by=" + this.config.order_by + "&mode=" + this.config.mode;
            }
            axios.get(url, {
                'headers': {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + JSON.parse(localStorage.getItem('auth')).access_token
                }
            })
                .then(response => {
                    this.tags = response.data.data;
                    this.meta = convertPage(response.data.meta);
                })
                .catch(error => {
                    console.log(error);
                });
        },
        showTag(id) {
            this.id = id
            $("#showModalTag").modal('show');
        },
        editTag(id) {
            this.id = id
            $("#editModalTag").modal('show');
        }
    },
    mounted() {
        this.loadData();
    },
};
</script>
  
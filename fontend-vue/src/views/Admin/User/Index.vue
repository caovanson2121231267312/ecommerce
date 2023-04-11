<template>
    <Breadcrumb />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-5">
                            <RouterLink to="/admin/users/create" class="btn btn-danger mb-2">
                                <i class="mdi mdi-plus-circle me-2"></i> Add User
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
                                    <span class="fs-5 fw-bold text-dark me-2">User</span>
                                    <span v-if="config.order_by == 'name'">
                                        <i v-if="config.mode == 'desc'" class="fas fa-sort-down"></i>
                                        <i v-else class="fas fa-sort-up"></i>
                                    </span>
                                    <span v-else>
                                        <i class="fas fa-sort"></i>
                                    </span>
                                </th>
                                <th @click="softBy('permissions_count')">
                                    <span class="fs-5 fw-bold text-dark me-2">Role</span>
                                    <span v-if="config.order_by == 'permissions_count'">
                                        <i v-if="config.mode == 'desc'" class="fas fa-sort-down"></i>
                                        <i v-else class="fas fa-sort-up"></i>
                                    </span>
                                    <span v-else>
                                        <i class="fas fa-sort"></i>
                                    </span>
                                </th>
                                <th @click="softBy('users_count')">
                                    <span class="fs-5 fw-bold text-dark me-2">Users</span>
                                    <span v-if="config.order_by == 'users_count'">
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
                            <tr v-for="user in users" :key="user.id">
                                <td class="dt-checkboxes-cell dtr-control" style="outline: none;">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input dt-checkboxes">
                                        <label class="form-check-label">&nbsp;</label>
                                    </div>
                                </td>
                                <td>{{ user.id }}</td>
                                <td class="sorting">
                                    <div class="d-flex">
                                        <div>
                                            <img class="border border-2 rounded-circle me-2" width="60"
                                                :src="domain + user.avatar" :alt="user.email" />
                                        </div>
                                        <div>
                                            <div>
                                                <span class="text-dark fw-bold">Name: </span>
                                                <span>{{ user.name }}</span>
                                            </div>
                                            <div>
                                                <span class="text-dark fw-bold">Email: </span>
                                                <span>{{ user.email }}</span>
                                            </div>
                                            <div>
                                                <span class="text-dark fw-bold">Date of Birth: </span>
                                                <span>{{ user.dob }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="sorting">
                                    <span class="badge rounded-pill bg-danger me-1" v-for="(item, index) in user.roles"
                                        v-bind:key="index">
                                        {{ item.name }}
                                    </span>
                                </td>
                                <td class="sorting">{{ user.users }}</td>
                                <td>
                                    <div>
                                        <span class="fw-bold">Created at: </span>
                                        <span>{{ user.created_at }}</span>
                                    </div>
                                    <div>
                                        <span class="fw-bold">Updated at: </span>
                                        <span>{{ user.updated_at }}</span>
                                    </div>
                                </td>
                                <td class="table-action">
                                    <a href="javascript:void(0);" @click="showuser(user.id)" class="action-icon text-info">
                                        <i class="mdi mdi-eye"></i>
                                    </a>
                                    <RouterLink :to="'/admin/users/edit/' + user.id" class="action-icon text-success">
                                        <i class="mdi mdi-square-edit-outline"></i>
                                    </RouterLink>
                                    <Delete :id="user.id" :load-data="loadData" />
                                </td>
                            </tr>
                            <tr v-if="!users.length">
                                <td colspan="7" class="text-center">No users found</td>
                            </tr>
                        </tbody>
                    </table>

                    <Pagination :changePage="changePage" v-if="Object.keys(meta).length !== 0" :meta="meta" />

                    <Show :id="id" :load-data="loadData" />
                </div>
            </div>

        </div>
    </div>
</template>
  
<script>
import Breadcrumb from '@/components/Layout/Admin/Breadcrumb.vue';
import Pagination from '@/components/Page/Pagination.vue';
import { convertPage, domain } from '../../../config';
import Create from './Create.vue';
import Show from './Show.vue';
import Delete from './Delete.vue';

import axios from 'axios';
import api from '../../../stores/axios';

export default {
    components: {
        Breadcrumb,
        Pagination,
        Create,
        Show,
        Delete,
    },
    data() {
        return {
            users: [],
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
            let url = "api/admin/users?page=" + this.config.page
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
                    this.users = response.data.data;
                    this.meta = convertPage(response.data.meta);
                })
        },
        showuser(id) {
            this.id = id
            $("#showModaluser").modal('show');
        },
    },
    mounted() {
        this.loadData();
    },
};
</script>
  
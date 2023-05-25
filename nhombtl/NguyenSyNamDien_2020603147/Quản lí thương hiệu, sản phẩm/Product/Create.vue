<template>
    <Breadcrumb />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-5">
                            <RouterLink to="/admin/users" class="btn btn-danger mb-2">
                                <i class="fas fa-chevron-left"></i> Back
                            </RouterLink>
                        </div>
                        <div class="col-sm-7">
                            <div class="text-sm-end">
                                <button type="button" class="btn btn-success mb-2 me-1"><i
                                        class="mdi mdi-cog-outline"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <form class="col-md-8">
                            <h3>Add New Product</h3>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Name</label>
                                <input class="form-control" v-model="name"
                                    :class="{ 'form-control': true, 'is-invalid': errors && errors.name }">
                                <template v-if="errors" v-for="(item, index) in errors.name" v-bind:key="index">
                                    <span class="text-danger">{{ item }}</span>
                                </template>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Images</label>
                                <div v-if="images.length > 0">
                                    <div v-for="(input, index) in images" :key="index">
                                        <div class="row mb-2">
                                            <div class="col-8 col-xl-9 col-xxl-10">
                                                <input class="form-control" type="file"
                                                    v-on:change="onchangeFile(index, $event)"
                                                    :class="{ 'form-control': true, 'is-invalid': errors && errors.images }">
                                            </div>
                                            <div class="col-4 col-xl-3 col-xxl-2">
                                                <button v-if="index == 0" type="button" class="btn btn-info w-100"
                                                    @click="addInput">
                                                    <i class="fas fa-plus"></i> Add more
                                                </button>
                                                <button v-else type="button" class="btn btn-danger w-100"
                                                    @click="removeInput(index)">
                                                    <i class="fas fa-minus-circle"></i> Remove
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <template v-if="errors" v-for="(item, index) in errors.images" v-bind:key="index">
                                    <span class="text-danger">{{ item }}</span>
                                </template>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Category</label>
                                <div v-if="categories.length > 0">
                                    <VueMultiselect v-model="category_id" :options="categories" :preserve-search="true"
                                        label="name" track-by="name">
                                    </VueMultiselect>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Brands</label>
                                <div v-if="brands.length > 0">
                                    <VueMultiselect v-model="brand_id" :options="brands" :preserve-search="true"
                                        label="name" track-by="name">
                                    </VueMultiselect>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tags</label>
                                <div v-if="tags.length > 0">
                                    <VueMultiselect v-model="tag_ids" :options="tags" :multiple="true"
                                        :close-on-select="false" :clear-on-select="false" :preserve-search="true"
                                        label="name" track-by="name">
                                    </VueMultiselect>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Price</label>
                                <input class="form-control" v-model="price"
                                    :class="{ 'form-control': true, 'is-invalid': errors && errors.price }"
                                    v-on:change="handlePrice">
                                <template v-if="errors" v-for="(item, index) in errors.price" v-bind:key="index">
                                    <span class="text-danger">{{ item }}</span>
                                </template>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Sale</label>
                                <input class="form-control" v-model="sale"
                                    :class="{ 'form-control': true, 'is-invalid': errors && errors.sale }">
                                <template v-if="errors" v-for="(item, index) in errors.sale" v-bind:key="index">
                                    <span class="text-danger">{{ item }}</span>
                                </template>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Time Sale</label>
                                <input class="form-control" v-model="time_sale" type="date"
                                    :class="{ 'form-control': true, 'is-invalid': errors && errors.time_sale }">
                                <template v-if="errors" v-for="(item, index) in errors.time_sale" v-bind:key="index">
                                    <span class="text-danger">{{ item }}</span>
                                </template>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Quantity</label>
                                <input type="number" v-model="quantity"
                                    :class="{ 'form-control': true, 'is-invalid': errors && errors.quantity }">
                                <template v-if="errors" v-for="(item, index) in errors.quantity" v-bind:key="index">
                                    <span class="text-danger">{{ item }}</span>
                                </template>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Description</label>
                                <textarea :class="{ 'form-control': true, 'is-invalid': errors && errors.description }"
                                    v-model="description"></textarea>
                                <template v-if="errors" v-for="(item, index) in errors.description" v-bind:key="index">
                                    <span class="text-danger">{{ item }}</span>
                                </template>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Note</label>
                                <textarea :class="{ 'form-control': true, 'is-invalid': errors && errors.note }"
                                    v-model="note"></textarea>
                                <template v-if="errors" v-for="(item, index) in errors.note" v-bind:key="index">
                                    <span class="text-danger">{{ item }}</span>
                                </template>
                            </div>
                            <div class="mb-3">
                                <ckeditor :editor="editor" v-model="content" :config="editorConfig"></ckeditor>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Status</label>
                                <div class="row row-cols-3 ps-2">
                                    <div class="form-check form-checkbox-success mb-1">
                                        <input class="form-check-input" v-model="status" type="checkbox"
                                            :class="{ 'form-control': true, 'is-invalid': errors && errors.status }">
                                        <label class="form-check-label" for="checkmeout0">Private</label>
                                    </div>
                                </div>
                                <template v-if="errors" v-for="(item, index) in errors.status" v-bind:key="index">
                                    <span class="text-danger">{{ item }}</span>
                                </template>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    Product Information
                                    <button type="button" class="btn btn-info ms-2" @click="addInfor">
                                        <i class="fas fa-plus-circle"></i> Add more
                                    </button>
                                </label>
                                <div class="row">
                                    <div v-for="(input, index) in infor" :key="index">
                                        <div class="row mb-2">
                                            <div class="col-5">
                                                <input class="form-control" :value="input.value"
                                                    v-on:change="onchangeText(index, 'value', $event)" type="text">
                                            </div>
                                            <div class="col-5">
                                                <input class="form-control"
                                                    v-on:change="onchangeText(index, 'detail', $event)" type="text">
                                            </div>
                                            <div class="col-2">
                                                <button type="button" class="btn btn-danger w-100"
                                                    @click="removeInfo(index)">
                                                    <i class="fas fa-minus-circle"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <template v-if="errors" v-for="(item, index) in errors.infor" v-bind:key="index">
                                    <span class="text-danger">{{ item }}</span>
                                </template>
                            </div>

                            <button type="button" @click="sendData()" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
import api from '../../../stores/axios'
import { alert } from "../../../config"
import Breadcrumb from '@/components/Layout/Admin/Breadcrumb.vue';
import VueMultiselect from 'vue-multiselect'
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import moment from 'moment';
// import SimpleUploadAdapter from '@ckeditor/ckeditor5-upload/src/adapters/simpleuploadadapter';

export default {
    components: {
        Breadcrumb,
        VueMultiselect,
    },
    data() {
        return {
            editor: ClassicEditor,
            editorConfig: {
                simpleUpload: {
                    uploadUrl: '/your-backend-upload-endpoint',

                    headers: {
                        'X-CSRF-TOKEN': 'CSRF-Token',
                        Authorization: 'Bearer <JSON Web Token>',
                    }
                },
            },
            name: null,
            price: null,
            price_number: null,
            sale: null,
            time_sale: null,
            note: null,
            images: [{ value: null },],
            infor: [
                { value: "Công nghệ màn hình", detail: null },
                { value: "Độ phân giải", detail: null },
                { value: "Ram", detail: null },
                { value: "Cpu", detail: null },
                { value: "Dung lượng pin", detail: null },
                { value: "Hệ điều hành", detail: null },
            ],
            content: '',
            quantity: 0,
            description: null,
            status: 1,
            errors: null,
            categories: [],
            tags: [],
            brands: [],
            category_id: null,
            tag_ids: [],
            brand_id: null,
        }
    },
    props: {
    },
    computed: {
        auth() {
            return this.$store.getters.auth
        },
    },
    methods: {
        addInput() {
            this.images.push({ value: null })
        },
        removeInput(index) {
            this.images.splice(index, 1)
        },
        addInfor() {
            this.infor.push({ value: null, detail: null })
        },
        removeInfo(index) {
            this.infor.splice(index, 1)
        },
        onSelect(option) {
            console.log(option.name);
            console.log(option);
        },
        handlePrice(e) {
            console.log(e.target.value)
            this.price = parseInt(e.target.value).toLocaleString('de-DE')
            this.price_number = e.target.value
        },
        handleCheckboxChange(value) {
            const parsedValue = parseInt(value, 10);
            if (!isNaN(parsedValue)) {
                const index = this.check.indexOf(parsedValue);
                if (index === -1) {
                    this.check.push(parsedValue);
                } else {
                    this.check.splice(index, 1);
                }
            }
        },
        onchangeFile(i, e) {
            const file = e.target.files[0]
            const TaskCopy = this.images.map(function (item, index) {
                if (index == i) {
                    item.value = file
                }
                return item
            });
            this.images = TaskCopy
        },
        onchangeText(i, mode, e) {
            const data = e.target.value
            const TaskCopy = this.infor.map(function (item, index) {
                if (index == i) {
                    if (mode == 'value') {
                        item.value = data
                    } else {
                        item.detail = data
                    }
                }
                return item
            });
            this.infor = TaskCopy
        },
        async sendData() {
            let form = await new FormData()
            await form.append('name', this.name)
            await form.append('description', this.description)
            await form.append('price', this.price_number)
            await form.append('sale', this.sale)
            await form.append('note', this.note)
            await form.append('quantity', this.quantity)
            await form.append('time_sale', moment(this.time_sale).format('DD-MM-YYYY'))
            console.log(moment(this.time_sale).format('DD-MM-YYYY'))
            await form.append('status', this.status)
            await form.append('content', this.content)
            await form.append('category_id', this.category_id.id)
            await form.append('brand_id', this.brand_id.id)
            if (this.images.length > 0) {
                const images = this.images.map(arr => arr.value).filter(value => value !== null);
                for (let i = 0; i < images.length; i++) {
                    await form.append('images[]', images[i])
                }
            }
            if (this.infor.length > 0) {
                const infor = this.infor
                // .map(arr => arr.value)
                for (let i = 0; i < infor.length; i++) {
                    await form.append("infor[name][]", infor[i].value)
                    await form.append("infor[detail][]", infor[i].detail)
                }
            }
            for (let i = 0; i < this.tag_ids.length; i++) {
                await form.append('tags[]', this.tag_ids[i].id)
            }
            try {
                const data = await api.post('api/admin/products', form, {
                    'Content-Type': 'multipart/form-data',
                    'Authorization': 'Bearer ' + this.auth.access_token
                })
                await alert('success', 'top-center', 'Đã thêm 1 danh mục mới.');
                await this.$router.push('/admin/users');
            } catch (e) {
                console.log(e)
                this.errors = e.error
            }
        },
        async getDatas() {
            const data = await api.get('api/admin/products/create', {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + this.auth.access_token
            })
            this.categories = await data.data.categories
            this.tags = await data.data.tags
            this.brands = await data.data.brands
        }
    },
    mounted() {
        this.getDatas();
    },
    watch: {
        sale(newValue, oldValue, c) {
            if (newValue > 100 || newValue < 0) {
                this.sale = oldValue
                this.$swal({
                    title: 'Error!',
                    html: 'Giảm giá không được lớn hơn 100% và nhỏ hơn 0%.',
                    timer: 2000,
                    timerProgressBar: true
                })
            }
        }
    }
}
</script>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>
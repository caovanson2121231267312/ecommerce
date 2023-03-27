<template :v-if="meta" >
    <div class="row">
        <div class="col-sm-12 col-md-5">
            <div class="dataTables_info" id="products-datatable_info" role="status" aria-live="polite">
                Showing items {{ meta.from }} to {{ meta.to }} of {{ meta.total }}
            </div>
        </div>
        <div class="col-sm-12 col-md-7">
            <div class="float-end" id="products-datatable_paginate">
                <ul class="pagination pagination-rounded">
                    <li class="paginate_button page-item previous" :class="{ 'disabled': !meta.links[0].url }">
                        <a href="#" aria-controls="products-datatable" data-dt-idx="0" tabindex="0" class="page-link"
                            @click.prevent="changePage(meta.current_page - 1)">
                            <i class="mdi mdi-chevron-left"></i>
                        </a>
                    </li>
                    <li v-for="link in meta.links" :key="link.label"
                        :class="{ 'paginate_button': true, 'page-item': true, 'active': link.active }">
                        <a v-if="link.url" href="#" aria-controls="products-datatable" tabindex="0" class="page-link"
                            @click.prevent="changePage(getPageNumber(link.url))" v-html="link.label">
                        </a>
                        <span v-else class="page-link" v-html="link.label">
                        </span>
                    </li>
                    <li class="paginate_button page-item next"
                        :class="{ 'disabled': !meta.links[meta.links.length - 1].url }">
                        <a href="#" aria-controls="products-datatable" data-dt-idx="4" tabindex="0" class="page-link"
                            @click.prevent="changePage(meta.current_page + 1)">
                            <i class="mdi mdi-chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>
  
<script setup>
defineProps({
    meta: {
        type: Object,
        required: true
    },
    changePage: {
        type: Function,
        required: true
    }
})
</script>

<script>
export default {
    methods: {
        getPageNumber(url) {
            return parseInt(url.split('page=')[1])
        },
    },
}
</script>
  
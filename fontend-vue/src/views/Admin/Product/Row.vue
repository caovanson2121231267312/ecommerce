<template v-if="value">
    <td class="dt-checkboxes-cell dtr-control" style="outline: none;">
        <div class="form-check d-flex align-items-center">
            <input type="checkbox" class="form-check-input dt-checkboxes">
            <label class="form-check-label">&nbsp;</label>
        </div>
    </td>
    <td class="sorting">
        <div class="d-flex align-items-center">
            <div class="height-image me-1 flex-shrink-0">
                <Image :images="value.images" />
            </div>
            <div class="flex-grow-1">
                <div class="d-inline-block text-ellipsis-1" :v-tooltip="value.name">
                    {{ value.name }}
                </div>
                <div>
                    <Stars :rates_count="value.rates_count" :rate="value.avg_rate" />
                </div>
            </div>
        </div>
    </td>
    <td class="sorting">
        <div>
            <div>
                <span class="fw-bold">Category: </span>
                <RouterLink v-if="value.category" :title="value.category.id" class="" to="#">
                    {{ value.category.name }}
                </RouterLink>
            </div>
            <div>
                <span class="fw-bold">Brand: </span>
                <RouterLink v-if="value.brand" :title="value.brand.id" class="" to="#">
                    {{ value.brand.name }}
                </RouterLink>
            </div>
            <div>
                <span class="fw-bold">User: </span>
                <RouterLink v-if="value.user" :title="value.user.email" class="" to="#">
                    {{ value.user.name }}
                </RouterLink>
            </div>
        </div>
    </td>
    <td class="sorting">
        <div>
            <div>
                <span class="fw-bold">Price: </span>
                <RouterLink class="text-danger" to="#">
                    {{ formatCurrency(value.price) }}
                </RouterLink>
            </div>
            <div>
                <span class="fw-bold">Sale: </span>
                <RouterLink title="value.time_sale" class="" to="#">
                    {{ value.sale }}
                </RouterLink>
            </div>
            <div>
                <span class="fw-bold">Quantity: </span>
                <RouterLink class="" to="#">
                    {{ value.quantity }}
                </RouterLink>
            </div>
        </div>
    </td>
    <td>
        <div class="">
            <span v-if="value.status == 1" class="badge bg-success">Public</span>
            <span v-else class="badge bg-danger">Private</span>
        </div>
    </td>
    <td>
        <div class="">
            <div>
                {{ value.created_at }}
            </div>
            <div>
                {{ value.updated_at }}
            </div>
        </div>
    </td>
    <td class="table-action">
        <a href="javascript:void(0);" class="action-icon text-info">
            <i class="mdi mdi-eye"></i>
        </a>
        <a href="javascript:void(0);" class="action-icon text-success">
            <i class="mdi mdi-square-edit-outline"></i>
        </a>
        <a href="javascript:void(0);" class="action-icon text-danger">
            <i class="mdi mdi-delete"></i>
        </a>
    </td>
</template>

<script>
import Stars from '@/components/Rate/Stars.vue';
import Image from './Image.vue';
import { convertPage, firstImage, formatCurrency } from '../../../config';
import {
    RouterLink
} from 'vue-router'

export default {
    props: {
        value: {
            type: Object,
            required: true
        },
    },
    components: {
        Image,
        Stars,
    },
    methods: {
        formatCurrency,
    },
}
</script>


<style lang="scss" scoped>
.height-image {
    height: 65px;
    width: 65px;
    padding: 5px;
    text-align: center;

    img {
        object-fit: scale-down;
    }
}
</style>
  
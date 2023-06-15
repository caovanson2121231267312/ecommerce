<template>
    <Breadcrumb />

    <div class="row" v-if="data">
        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3 col-xxl-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="mdi mdi-account-multiple widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-normal mt-0" title="Number of Customers">{{ $t('customers') }}</h5>
                    <h3 class="mt-3 mb-3">{{ data.users }}</h3>
                    <p class="mb-0 text-muted">
                        <span class="text-success me-2"><i class="mdi mdi-arrow-up-bold"></i> 5.27%</span>
                        <span class="text-nowrap">{{ $t('since_last_month') }}</span>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3 col-xxl-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="mdi mdi-cart-plus widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-normal mt-0" title="Number of Orders">{{ $t('orders') }}</h5>
                    <h3 class="mt-3 mb-3">{{ data.orders }}</h3>
                    <p class="mb-0 text-muted">
                        <span class="text-danger me-2"><i class="mdi mdi-arrow-down-bold"></i> 1.08%</span>
                        <span class="text-nowrap">{{ $t('since_last_month') }}</span>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3 col-xxl-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="mdi mdi-currency-usd widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-normal mt-0" title="Average Revenue">{{ $t('revenue') }}</h5>
                    <h3 class="mt-3 mb-3">{{ formatCurrency(data.revenue) }} đ</h3>
                    <p class="mb-0 text-muted">
                        <span class="text-danger me-2"><i class="mdi mdi-arrow-down-bold"></i> 7.00%</span>
                        <span class="text-nowrap">{{ $t('since_last_month') }}</span>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3 col-xxl-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="mdi mdi-pulse widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-normal mt-0" title="Growth">{{ $t('products') }}</h5>
                    <h3 class="mt-3 mb-3">{{ data.products }}</h3>
                    <p class="mb-0 text-muted">
                        <span class="text-success me-2"><i class="mdi mdi-arrow-up-bold"></i> 4.87%</span>
                        <span class="text-nowrap">{{ $t('since_last_month') }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5" v-if="loading">
        <div class="col-12 col-lg-6">
            <Bar id="chart" :data="chartData" />
        </div>
        <div class="col-12 col-lg-6">
            <PolarArea id="chart" :data="chartData2" :options="options" />
        </div>
    </div>
</template>
  
<script>
import { Bar, PolarArea } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, RadialLinearScale, ArcElement, } from 'chart.js'
import api from "../../../stores/axios"
import Breadcrumb from '@/components/Layout/Admin/Breadcrumb.vue';
import { formatCurrency } from '../../../config'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, RadialLinearScale, ArcElement)

export default {
    name: 'BarChart',
    components: {
        Bar,
        PolarArea,
        Breadcrumb
    },
    data() {
        return {
            data: null,
            loading: false,
            chartOptions: {
                responsive: true,
                default: () => {
                    // backgroundColor: '#9BD0F5',
                }
            },
            chartData: {
                labels: ['January', 'February', 'March'],
                datasets: [
                    {
                        label: 'Data One',
                        backgroundColor: '#f87979',
                        data: [40, 20, 12]
                    }
                ]
            },
            chartData2: {
                labels: [
                ],
                datasets: []
            },
            users_count: [],
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        }
    },
    methods: {
        formatCurrency(data) {
            return formatCurrency(data);
        },
        getAnalysis() {
            this.loading = false
            api.get("api/admin/home", {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + JSON.parse(localStorage.getItem('auth')).access_token
            }, this)
                .then(response => {
                    console.log(response)
                    this.data = response.data;
                    let datasets = {
                        label: 'Roles',
                        data: [],
                        backgroundColor: [
                            'rgb(255, 99, 132)',
                            'rgb(75, 192, 192)',
                            'rgb(255, 205, 86)',
                            'rgb(201, 203, 207)',
                        ]
                    }

                    this.data.roles.forEach(element => {
                        this.chartData2.labels.push(element.name)
                        datasets.data.push(element.users_count)
                    });

                    this.chartData2.datasets.push(datasets)

                    this.loading = true
                })
        },
    },
    mounted() {
        // this.getAnalysis();
    },
    created() {
        this.getAnalysis();
    }
}
</script>
<style scoped >
#chart {
    width: 100%;
    height: 100%;
}
</style >

<template v-if="rate">
    <div class="mt-1">
        <span v-for="i in Math.floor(rate)" :key="i"><i class="fas fa-star text-warning"></i></span>
        <span v-if="rate - Math.floor(rate) > 0.5"><i class="fas fa-star-half-alt text-warning"></i></span>
        <span v-else-if="rate - Math.floor(rate) > 0"><i class="fas fa-star-half-alt text-warning"></i></span>
        <span v-for="i in Math.floor(5 - rate)" :key="i"><i class="far fa-star text-warning"></i></span>
        <span v-if="rates_count">
            ( {{ rates_count }} đánh giá )
        </span>
    </div>
</template>
  
<script>
export default {
    props: {
        rate: {
            type: String,
            required: true
        },
        rates_count: {
            type: Number,
        }
    }
}
</script>
  
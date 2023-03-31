<template v-if="images">
    <img class="img-fluid h-100 w-100 object-fit-cover" :src="firstImage" />
</template>
  
<script>
import { domain } from '../../../config';

export default {
    props: {
        images: {
            type: String,
            required: true
        },
    },
    computed: {
        firstImage() {
            if (this.images.length > 0) {
                const images = JSON.parse(this.images)
                return domain + images[0].image;
            } else {
                return null;
            }
        }
    },
}
</script>
  
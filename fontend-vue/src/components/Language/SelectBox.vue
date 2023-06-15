<template>
    <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
        aria-expanded="false">
        <img :src="selectedLang.image" alt="user-image" class="me-0 me-sm-1" height="12">
        <span class="align-middle d-none d-lg-inline-block">
            {{ selectedLang.text }}
        </span>
        <i class="mdi mdi-chevron-down d-none d-sm-inline-block align-middle"></i>
    </a>
    <div>
        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated">
            <div v-for="(item, index) in optionLangs" v-bind:key="index" :value="item.value"
                @click.prevent="callSetLangActions(item.value)" class="dropdown-item">
                <img :src="item.image" alt="user-image" class="me-1" height="12">
                <span class="align-middle">{{ item.text }}</span>

            </div>
        </div>
    </div>
</template>

<script>
import images from "../../assets/images/index"

export default {
    data: () => ({
        optionLangs: [
            {
                image: images.en,
                text: 'English',
                value: 'en'
            },
            {
                image: images.vi,
                text: 'Vietnamese',
                value: 'vi'
            },
            {
                image: images.ja,
                text: 'Japanese',
                value: 'ja'
            },
            {
                image: images.ru,
                text: 'Russian',
                value: 'ru'
            },
        ]
    }),
    computed: {
        lang() {
            return this.$store.getters.locale
        },
        selectedLang() {
            return this.optionLangs.find(item => item.value === this.lang)
        },
    },
    methods: {
        callSetLangActions(lang) {
            this.$i18n.locale = lang
            this.$store.dispatch('setLang', lang)
        },

    }

}
</script>
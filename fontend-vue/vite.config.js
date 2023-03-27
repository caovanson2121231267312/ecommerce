import { fileURLToPath, URL } from 'node:url'

import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

// https://vitejs.dev/config/
export default defineConfig({
    plugins: [vue(), 'vue-meta'],
    resolve: {
        alias: {
            '@': fileURLToPath(new URL('./src', import.meta.url)),
            util: 'util/'
            //  'bootstrap-vue$': 'bootstrap-vue/src/index.js',
        }
    },
    productionSourceMap: false
})

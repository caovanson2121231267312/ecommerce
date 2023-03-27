import products from './products/ListProducts'
import api from './axios'

const actions = {
    async alert({ commit }, data) {
        commit('alert', data)
    },
    async login({ commit }, data) {
        commit('login', data.data)
    },
    async logout({ commit }, auth) {
        try {
            await api.post(
                'api/auth/logout',
                {},
                {
                    'Content-Type': 'application/json',
                    Authorization: 'Bearer ' + auth.access_token
                }
            )

            commit('logout')
        } catch (e) {
            console.log(e)
        }
    },
    async signup({ commit }, data) {
        commit('signup', data)
    },
    async getProducts({ commit }) {
        const data = await api.get('api/products')
        commit('getProducts', data.data)
    },
    async getCategories({ commit }) {
        const data = await api.get('api/categories')
        commit('getCategories', data.data)
    },
    async productDetail({ commit }, slug) {
        const data = await api.get('api/product/' + slug)
        console.log(data)
        commit('productDetail', data.data)
    },
    async isLoading({ commit }, type) {
        console.log(type)
        commit('isLoading', type)
    },
    async getProductInCart({ commit }, array) {
        const data = await api.post('api/products', array)
        commit('getProductInCart', data)
    },
    async addToCart({ commit }, product) {
        commit('addToCart', product)
    },
    async minusToCart({ commit }, product) {
        commit('minusToCart', product)
    },
    async removeCart({ commit }, id) {
        1
        commit('removeCart', id)
    },
    async clearCart({ commit }) {
        commit('clearCart')
    }
}

export default actions

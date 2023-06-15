import products from './products/ListProducts'
import api from './axios'

const actions = {
    async setLang({ commit }, payload) {
        commit('SET_LANG', payload)
    },
    async alert({ commit }, data) {
        commit('alert', data)
    },
    async login({ commit }, data) {
        commit('login', data.data)
    },
    async SocialLogin({ commit }, data) {
        commit('login', data)
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
    async getProducts({ commit }, value) {
        const data = await api.get(
            'api/products?category_id=' + value.name + '&page=' + value.page,
            {}
        )
        commit('getProducts', { slug: value.slug, data: data.data })
    },
    async rateOfProduct({ commit }, value) {
        const data = await api.get('api/rateOfProduct/' + value)
        commit('getRateOfProduct', data)
    },
    async hotSale({ commit }) {
        const data = await api.get('api/hotSale')
        commit('hotSale', data.data)
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
        commit('removeCart', id)
    },
    async clearCart({ commit }) {
        commit('clearCart')
    },
    async getTechnicalSupport({ commit }, payload) {
        commit('technicalSupport', payload)
    },
    async setTechnicalId({ commit }, payload) {
        commit('setTechnicalId', payload)
    },
    async messages({ commit }, payload) {
        commit('messages', payload)
    },
    async addMessage({ commit }, payload) {
        commit('addMessage', payload)
    },
    async getFriends({ commit }, payload) {
        commit('getFriends', payload)
    }
}

export default actions

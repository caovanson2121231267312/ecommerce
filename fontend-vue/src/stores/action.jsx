import products from './products/ListProducts'

const actions = {
    async getProducts({ commit }) {
        const data = await products.get('api/products')
        commit('getProducts', data.data)
    },
    async productDetail({ commit }, slug) {
        const data = await products.get('api/product/' + slug)
        console.log(data)
        commit('productDetail', data.data)
    },
    async isLoading({ commit }, type) {
        console.log(type)
        commit('isLoading', type)
    },
    async getProductInCart({ commit }, array) {
        const data = await products.post('api/products', array)
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
    }
}

export default actions

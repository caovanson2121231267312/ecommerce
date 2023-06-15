import { createToast } from 'mosha-vue-toastify'
// import app from '../main'

const mutations = {
    SET_LANG(state, payload) {
        state.locale = payload
        localStorage.setItem('locale', payload)
    },
    alert(state, payload) {
        state.alert = payload
    },
    login(state, payload) {
        state.auth = payload
        localStorage.setItem('auth', JSON.stringify(state.auth))
    },
    logout(state) {
        state.auth = null
        localStorage.removeItem('auth')
    },
    signup(state, payload) {
        state.signup = payload.user
    },
    getProducts(state, payload) {
        state.products[payload.slug] = payload.data
    },
    getRateOfProduct(state, payload) {
        state.rates = payload.data
    },
    hotSale(state, payload) {
        state.hotSale = payload
    },
    getCategories(state, payload) {
        state.categories = payload
    },
    productDetail(state, payload) {
        state.product = payload
    },
    isLoading(state, type) {
        state.isLoading = type
    },
    technicalSupport(state, payload) {
        state.technicalSupport = payload
    },
    setTechnicalId(state, payload) {
        state.technical_id = payload
    },
    messages(state, payload) {
        state.messages = payload
    },
    addMessage(state, payload) {
        state.messages.map((x) => x.id == payload.id)
        if (!state.messages.find((message) => message.id === payload.id)) {
            state.messages.push(payload)
        }
    },
    getFriends(state, payload) {
        state.friends = payload
    },
    addToCart(state, item) {
        if (state.cart.length > 15) {
            createToast('Đã đạt tối đa sản phẩm trong giỏ', {
                type: 'danger',
                transition: 'zoom',
                showIcon: 'true',
                hideProgressBar: 'false',
                position: 'top-center'
            })
            return false
        }
        state.cart.push(item)
        createToast('Đã thêm sản phâm vào giỏ', {
            type: 'success',
            transition: 'zoom',
            showIcon: 'true',
            hideProgressBar: 'false',
            position: 'top-center'
        })
        localStorage.setItem('cart', JSON.stringify(state.cart))
    },
    minusToCart(state, id) {
        console.log(state.cart)
        let indexToDelete = state.cart.findIndex((obj) => obj.id === id)

        if (indexToDelete !== -1) {
            state.cart.splice(indexToDelete, 1)
        }
        localStorage.setItem('cart', JSON.stringify(state.cart))
    },
    removeCart(state, id) {
        state.cart = state.cart.filter((obj) => obj.id !== id)
        createToast('Đã xóa sản phẩm bạn chọn', {
            type: 'success',
            transition: 'zoom',
            showIcon: 'true',
            hideProgressBar: 'false',
            position: 'top-center'
        })
        localStorage.setItem('cart', JSON.stringify(state.cart))
    },
    clearCart(state) {
        state.cart = []
        localStorage.removeItem('cart')
    }
}

export default mutations

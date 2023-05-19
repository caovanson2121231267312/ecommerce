import { createStore } from 'vuex'
import mutations from './mutations'
import actions from './action'
import getters from './getters'

const store = createStore({
    state: {
        alert: null,
        auth: JSON.parse(localStorage.getItem('auth')) || null,
        signup: {},
        userList: [],
        products: [],
        categories: [],
        product: {},
        technicalSupport: [],
        technical_id: null,
        messages: [],
        friends: [],
        cart: JSON.parse(localStorage.getItem('cart')) || [],
        tasks: [],
        newTask: '',
        isLoading: true
    },
    mutations,
    actions,
    getters
})

export default store

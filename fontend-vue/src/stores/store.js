
import { createStore } from 'vuex'
import mutations from './mutations';
import actions from './action';
import getters from './getters';

const store = createStore({
  state: {
    userList: [],
    products: [],
    cart: [],
  },
  mutations,
  actions,
  getters,
})

export default store
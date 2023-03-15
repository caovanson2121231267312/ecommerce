const mutations = {
    addToCart(state, payload) {
      const product = state.products.find(product => product.id === payload.id);
      state.cart = [...state.cart, product];
    },
    removeFromCart(state, payload) {
      state.cart = state.cart.filter(product => product.id !== payload.id);
    }
};

export default mutations;
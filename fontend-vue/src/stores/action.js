const actions = {
    addToCart(context, payload) {
      context.commit("addToCart", payload);
    },
    removeFromCart(context, payload) {
      context.commit("removeFromCart", payload);
    }
};


export default actions;
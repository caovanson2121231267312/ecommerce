export const getters = {
    getTotal: state => {
      return state.cart.reduce((acc, item) => {
        return acc + item.price;
      }, 0);
    },
    isInCart: state => productId => {
      return state.cart.findIndex(product => product.id === productId) !== -1;
    }
  };

  export default getters;
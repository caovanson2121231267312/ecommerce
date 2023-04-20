export const getters = {
    getTotal: (state) => {
        return state.cart.reduce((acc, item) => {
            return acc + item.price
        }, 0)
    },
    isInCart: (state) => (productId) => {
        return state.cart.findIndex((product) => product.id === productId) !== -1
    },
    alert: (state) => state.alert,
    auth: (state) => state.auth,
    user: (state) => state.user,
    signup: (state) => state.signup,
    newTask: (state) => state.newTask,
    isLoading: (state) => state.isLoading,
    products: (state) => state.products,
    hotSale: (state) => state.hotSale,
    categories: (state) => state.categories,
    product: (state) => state.product,
    cart: (state) => state.cart,
    getCart: (state) => {
        if (localStorage.getItem('cart')) {
            state.cart = JSON.parse(localStorage.getItem('cart'))
        }
        return state.cart
    },
    tasks: (state) =>
        state.tasks.filter((task) => {
            return !task.completed
        }),
    completedTask: (state) =>
        state.tasks.filter((task) => {
            return task.completed
        })
}

export default getters

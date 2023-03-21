import { createToast } from 'mosha-vue-toastify'

const mutations = {
    // addToCart(state, payload) {
    //     const product = state.products.find((product) => product.id === payload.id)
    //     state.cart = [...state.cart, product]
    // },
    // removeFromCart(state, payload) {
    //     state.cart = state.cart.filter((product) => product.id !== payload.id)
    // },
    getTask(state, task) {
        state.newTask = task
    },
    addTask(state) {
        state.tasks.push({
            body: state.newTask,
            completed: false
        })
        console.log(state)
    },
    editTask(state, task) {
        var tasks = state.tasks
        tasks.splice(tasks.indexOf(task), 1)
        state.tasks = tasks
        state.newTask = task.body
    },
    removeTask(state, task) {
        var tasks = state.tasks
        tasks.splice(tasks.indexOf(task), 1)
    },
    completeTask(state, task) {
        task.completed = !task.completed
    },
    clearTask(state) {
        state.newTask = ''
    },
    getProducts(state, payload) {
        state.products = payload
    },
    productDetail(state, payload) {
        state.product = payload
    },
    isLoading(state, type) {
        state.isLoading = type
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

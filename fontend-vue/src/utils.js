import { createToast } from 'mosha-vue-toastify'

export const checkResponseCode = (code, title, message, vue) => {
    switch (code) {
        case 500:
            console.log(code, message)
            vue.$swal.fire({
                icon: 'error',
                title: 'Server Error',
                text: message
            })
            break
        case 401:
            localStorage.removeItem('auth')
            break
        case 403:
            let timerInterval
            vue.$swal({
                title: 'Auto close alert!',
                html: 'I will close in <b></b> milliseconds.',
                timer: 2000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading()
                    const b = Swal.getHtmlContainer().querySelector('b')
                    timerInterval = setInterval(() => {
                        b.textContent = Swal.getTimerLeft()
                    }, 100)
                },
                willClose: () => {
                    clearInterval(timerInterval)
                }
            }).then((result) => {
                if (result.dismiss === Swal.DismissReason.timer) {
                    console.log('I was closed by the timer')
                }
            })
            break
        case 422:
            vue.$swal({
                title: 'Auto close alert!',
                html: 'I will close in <b></b> milliseconds.',
                timer: 2000,
                timerProgressBar: true
            }).then((result) => {
                if (result.dismiss === Swal.DismissReason.timer) {
                    console.log('I was closed by the timer')
                }
            })
            break
        default:
            console.log(code, message)
    }
}

import { createToast } from 'mosha-vue-toastify'

export const domain = 'http://127.0.0.1:8000/'

export const formatCurrency = (value) => {
    if (value) {
        return parseInt(value).toLocaleString('de-DE')
    }
    return null
}

export const saleProduct = (price, sale) => {
    return price - (price * sale) / 100
}

export const getProductInCart = (data) => {
    const counts = data.reduce((acc, item) => {
        if (acc[item.id]) {
            acc[item.id] += item.count
        } else {
            acc[item.id] = item.count
        }
        return acc
    }, {})

    return Object.keys(counts).map((id) => ({
        id: Number(id),
        count: counts[id]
    }))
}

export const mergeProductInCart = (arr1, arr2) => {
    const temp = []
    console.log(arr1, arr2)

    arr1.forEach((x) => {
        arr2.forEach((y) => {
            if (x.id === y.id) {
                temp.push({ ...x, ...y })
            }
        })
    })

    return temp
}

export const firstImage = (images) => {
    if (images.length > 0) {
        const data = JSON.parse(images)
        return domain + data[0].image
    } else {
        return null
    }
}

export const alert = (type = 'success', position = 'top-center', message) => {
    createToast(message, {
        type: type,
        transition: 'zoom',
        showIcon: 'true',
        hideProgressBar: 'false',
        position: position
    })
}

export const notify = (type, position, value) => {
    const data = Object.values(JSON.parse(value))
    data.forEach((messages) => {
        messages.forEach((message) => {
            alert(type, position, message)
        })
    })
}

export const convertPage = (originalObj) => {
    const page = {
        ...originalObj,
        meta: {
            ...originalObj,
            links: originalObj.links
                .filter((link) => !isNaN(link.label))
                .map((link) => ({
                    ...link
                }))
        }
    }
    return page.meta
}

export const getFormattedTime = (timestamp) => {
    const now = moment()
    const time = moment(timestamp, 'HH:mm:ss DD/MM/YYYY')
    const diffMinutes = now.diff(time, 'minutes')
    const diffHours = now.diff(time, 'hours')
    const diffDays = now.diff(time, 'days')
    const diffYears = now.diff(time, 'years')

    if (diffMinutes < 2) {
        return 'vừa xong'
    } else if (diffMinutes < 60) {
        return diffMinutes + ' phút trước'
    } else if (diffDays < 1) {
        return diffHours + ' giờ trước'
    } else if (diffDays < 365) {
        return time.format('H:mm D/M')
    } else {
        return diffYears + ' năm trước'
    }
}

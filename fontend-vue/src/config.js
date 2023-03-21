export const domain = 'http://127.0.0.1:8000/'

export const formatCurrency = (value) => {
    return parseInt(value).toLocaleString('de-DE')
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

import axios from 'axios'
import { domain } from '../config'

const api = {
    async get(url, headers = {}, vue) {
        try {
            const data = await axios.get(domain + url, { headers: headers })
            console.log(data)
            console.log(url)
            return data
        } catch (e) {
            vue.$checkResponseCode(
                e.response.status,
                e.response.statusText,
                e.response.data.message ?? e.message,
                vue
            )
            throw e
        }
    },

    async post(url, data = {}, headers = {}, vue) {
        try {
            return await axios.post(domain + url, data, { headers: headers })
        } catch (e) {
            console.log(data, headers)
            vue.$checkResponseCode(
                e.response.status,
                e.response.statusText,
                e.response.data.message ?? e.message,
                vue
            )
            console.log(e.response.data)
            throw e.response.data
            // return e
        }
    },

    async put(url, data = {}, headers = {}) {
        try {
            let result = await axios.put(url, data, headers)

            return result
        } catch (e) {
            return e
        }
    },

    async delete(url, data = {}) {
        try {
            let result = await axios.delete(url, data)

            return result
        } catch (e) {
            return e
        }
    }
}

export default api

import axios from 'axios'
import { domain } from '../config'

const api = {
    async get(url, headers = {}) {
        try {
            return await axios.get(domain + url, { headers: headers })
        } catch (e) {
            console.log(e)
            return e
        }
    },

    async post(url, data = {}, headers = {}) {
        try {
            return await axios.post(domain + url, data, { headers: headers })
        } catch (e) {
            throw e.response.data
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

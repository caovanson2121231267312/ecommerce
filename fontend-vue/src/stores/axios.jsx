import axios from 'axios'
//const axios = require('axios'); // legacy way

// Make a request for a user with a given ID
axios
    .get('/user?ID=12345')
    .then(function (response) {
        // handle success
        console.log(response)
    })
    .catch(function (error) {
        // handle error
        console.log(error)
    })
    .finally(function () {
        // always executed
    })

// Optionally the request above could also be done as
axios
    .get('/user', {
        params: {
            ID: 12345
        }
    })
    .then(function (response) {
        console.log(response)
    })
    .catch(function (error) {
        console.log(error)
    })
    .finally(function () {
        // always executed
    })

// Want to use async/await? Add the `async` keyword to your outer function/method.
async function getUser() {
    try {
        const response = await axios.get('/user?ID=12345')
        console.log(response)
    } catch (error) {
        console.error(error)
    }
}

axios
    .post('/user', {
        firstName: 'Fred',
        lastName: 'Flintstone'
    })
    .then(function (response) {
        console.log(response)
    })
    .catch(function (error) {
        console.log(error)
    })

function getUserAccount() {
    return axios.get('/user/12345')
}

function getUserPermissions() {
    return axios.get('/user/12345/permissions')
}

Promise.all([getUserAccount(), getUserPermissions()]).then(function (results) {
    const acct = results[0]
    const perm = results[1]
})

axios({
    method: 'post',
    url: '/user/12345',
    data: {
        firstName: 'Fred',
        lastName: 'Flintstone'
    },
    headers: {
        'Content-Type': 'multipart/form-data'
    }
})
let data = new FormData()
let file = event.target.files[0]

data.append('name', 'my-file')
data.append('file', file)

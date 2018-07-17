import axios from 'axios'

export default {
  subscribe (email, cb, errCb) {
    return new Promise((resolve, reject) => {
      axios.post('/api/subscriptions', {
        email: email
      })
        .then((response) => resolve(response))
        .catch(error => reject(error.response))
    })
  }
}

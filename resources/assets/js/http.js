import axios from 'axios'

export default {
  get (url) {
    return new Promise((resolve, reject) => {
      axios.get(url)
        .then(response => resolve(response))
        .catch(error => reject(error))
    })
  },

  post (url, payload) {
    return new Promise((resolve, reject) => {
      axios.post(url, payload)
        .then(response => resolve(response))
        .catch(error => reject(error))
    })
  }
}

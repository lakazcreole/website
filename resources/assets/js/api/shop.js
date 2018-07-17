import axios from 'axios'

export default {
  getProducts () {
    return new Promise((resolve, reject) => {
      axios.get('/api/products?order=true')
        .then(response => resolve(response.data.data))
        .catch(error => reject(error.response))
    })
  },

  getOffers () {
    return new Promise((resolve, reject) => {
      axios.get('/api/products/offers')
        .then(response => resolve(response.data.data))
        .catch(error => reject(error.response))
    })
  }
}

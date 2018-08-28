import http from '../http'

export default {
  getProducts () {
    return http.get('/api/products?order=true')
  },

  getOffers () {
    return http.get('/api/products/offers')
  }
}

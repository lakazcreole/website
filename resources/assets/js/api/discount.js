import http from '../http'

export default {
  validateCode (code) {
    return http.get(`/api/promocodes/validate/${code}`)
  },

  get (id) {
    return http.get(`/api/discounts/${id}`)
  }
}

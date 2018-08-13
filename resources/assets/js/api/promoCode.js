import http from '../http'

export default {
  validate (code) {
    return http.get(`/api/promocodes/validate/${code}`)
  }
}

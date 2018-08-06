import http from '../http'

export default {
  subscribe (email) {
    return http.post('/api/subscriptions', {
      email: email
    })
  }
}

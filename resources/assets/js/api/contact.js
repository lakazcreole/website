import http from '../http'

export default {
  send ({ name, email, subject, message }) {
    return http.post('/api/contacts', {
      name: name,
      email: email,
      subject: subject,
      message: message
    })
  }
}

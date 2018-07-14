import axios from 'axios'

export default {
  send ({ name, email, subject, message }) {
    return new Promise((resolve, reject) => {
      axios.post('/api/contacts', {
        name: name,
        email: email,
        subject: subject,
        message: message
      })
        .then(response => resolve(response))
        .catch(error => reject(error.response))
    })
  }
}

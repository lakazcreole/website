<template>
  <modal name="contact-modal">
    <h3 slot="header">Contact</h3>
    <div v-if="serverError" slot="body">
      <p class="text-justify">Une erreur s'est produite. Veuillez réessayer plus tard.</p>
    </div>
    <div v-else slot="body">
      <p v-if="sent">
        Votre message a bien été envoyé. Je reviendrai vers vous dès que possible !
      </p>
      <div v-else>
        <div class="form-group">
          <label for="name">Nom</label>
          <input id="name" v-model="name" :class="inputClasses('name')" :disabled="waiting" type="text" placeholder="Nom">
          <div v-if="errors" class="invalid-feedback">
            <span v-for="(err, index) in errors.errors.name" :key="index">{{ err }} </span>
          </div>
        </div>
        <div class="form-group">
          <label for="email">E-mail</label>
          <input id="email" v-model="email" :class="inputClasses('email')" :disabled="waiting" type="email" placeholder="E-mail">
          <div v-if="errors" class="invalid-feedback">
            <span v-for="(err, index) in errors.errors.email" :key="index">{{ err }} </span>
          </div>
        </div>
        <div class="form-group">
          <label for="subject">Objet</label>
          <input id="subject" v-model="subject" :class="inputClasses('subject')" :disabled="waiting" type="text" placeholder="Objet">
          <div v-if="errors" class="invalid-feedback">
            <span v-for="(err, index) in errors.errors.subject" :key="index">{{ err }} </span>
          </div>
        </div>
        <div class="form-group">
          <label for="message">Message</label>
          <textarea id="message" v-model="message" :class="inputClasses('message')" :disabled="waiting" placeholder="Saisissez votre message..." rows="3"/>
          <div v-if="errors" class="invalid-feedback">
            <span v-for="(err, index) in errors.errors.message" :key="index">{{ err }} </span>
          </div>
        </div>
      </div>
    </div>
    <div slot="footer" class="text-right">
      <button type="button" class="btn btn-secondary" @click="hide">
        <span v-if="sent">Fermer</span>
        <span v-else>Annuler</span>
      </button>
      <button v-if="!serverError && !sent" :disabled="waiting" type="button" class="btn btn-primary ml-2" @click="onSubmit">
        <span v-if="waiting">En cours</span>
        <span v-else>Envoyer</span>
      </button>
    </div>
  </modal>
</template>

<script>
import axios from 'axios'
import Modal from './Modal'

export default {
  components: {
    Modal
  },

  props: {
    initialSubject: {
      type: String,
      required: false,
      default: ''
    },
    initialMessage: {
      type: String,
      required: false,
      default: ''
    }
  },

  data () {
    return {
      name: '',
      email: '',
      subject: '',
      message: '',
      serverError: false,
      errors: null,
      sent: false,
      waiting: false
    }
  },

  mounted () {
    this.subject = this.initialSubject
    this.message = this.initialMessage
  },

  methods: {
    // show () {
    //   console.log('ContactModal.show()') // eslint-disable-line no-console
    //   this.$modal.show('contact-modal')
    // },
    hide () {
      this.$modal.hide('contact-modal')
    },
    onSubmit: function () {
      this.waiting = true
      axios.post('/api/contacts', {
        name: this.name,
        email: this.email,
        subject: this.subject,
        message: this.message
      }).then(() => {
        this.waiting = false
        this.sent = true
      }).catch(error => {
        this.waiting = false
        if (error.response && error.response.status === 422) {
          this.errors = error.response.data
        } else {
          this.serverError = true
        }
      })
    },
    inputClasses: function (key) {
      if (this.errors && this.errors.errors.hasOwnProperty(key)) return 'form-control is-invalid'
      return 'form-control'
    }
  }
}
</script>

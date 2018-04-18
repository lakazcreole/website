<script>
import axios from 'axios'

export default {
  props: {
    defaultSubject: {
      type: String,
      required: true
    },
    defaultMessage: {
      type: String,
      required: true
    }
  },
  mounted() {
    this.subject = this.defaultSubject
    this.message = this.defaultMessage
  },
  components: {
    'modal': require('./Modal.vue').default
  },
  data() {
    return {
      name: '',
      email: '',
      subject: '',
      message: '',
      serverError: false,
      errors: null,
      sent: false,
      waiting: false,
    }
  },
  methods: {
    onSubmit: function() {
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
    inputClasses: function(key) {
      if (this.errors && this.errors.errors.hasOwnProperty(key)) return 'form-control is-invalid'
      return 'form-control'
    }
  }
}
</script>

<template>
  <modal @close="$emit('close')">
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
          <input v-model="name" type="text" :class="inputClasses('name')" id="name" placeholder="Nom" :disabled="waiting"/>
          <div v-if="errors" class="invalid-feedback">
            <span v-for="(err, index) in errors.errors.name" :key="index">{{ err }} </span>
          </div>
        </div>
        <div class="form-group">
          <label for="email">E-mail</label>
          <input v-model="email" type="email" :class="inputClasses('email')" id="email" placeholder="E-mail" :disabled="waiting"/>
          <div v-if="errors" class="invalid-feedback">
            <span v-for="(err, index) in errors.errors.email" :key="index">{{ err }} </span>
          </div>
        </div>
        <div class="form-group">
          <label for="subject">Objet</label>
          <input v-model="subject" type="text" :class="inputClasses('subject')" id="subject" placeholder="Objet" :disabled="waiting"/>
          <div v-if="errors" class="invalid-feedback">
            <span v-for="(err, index) in errors.errors.subject" :key="index">{{ err }} </span>
          </div>
        </div>
        <div class="form-group">
          <label for="message">Message</label>
          <textarea v-model="message" :class="inputClasses('message')" id="message" placeholder="Saisissez votre message..." rows="3" :disabled="waiting"></textarea>
          <div v-if="errors" class="invalid-feedback">
            <span v-for="(err, index) in errors.errors.message" :key="index">{{ err }} </span>
          </div>
        </div>
      </div>
    </div>
    <div slot="footer" class="text-right">
      <button type="button" class="btn btn-secondary" @click="$emit('close')">
        <span v-if="sent">Fermer</span>
        <span v-else>Annuler</span>
      </button>
      <button v-if="!serverError && !sent" type="button" class="btn btn-primary ml-2" @click="onSubmit" :disabled="waiting">
        <span v-if="waiting">En cours</span>
        <span v-else>Envoyer</span>
      </button>
    </div>
  </modal>
</template>

<template>
  <modal name="contact-modal" class="font-sans text-grey-darker">
    <div slot="header" class="text-2xl text-orange mb-3">Contact</div>
    <div v-if="serverError" slot="body">
      <p class="text-justify">Une erreur s'est produite. Veuillez réessayer plus tard.</p>
    </div>
    <div v-else slot="body">
      <p v-if="sent">
        Votre message a bien été envoyé. Je reviendrai vers vous dès que possible !
      </p>
      <div v-else>
        <FormInput v-model="name" :errors="errors.name" :disabled="waiting" name="name" label="Nom" placeholder="Nom" class="mb-3"/>
        <FormInput v-model="email" :errors="errors.email" :disabled="waiting" name="email" label="E-mail" type="email" placeholder="E-mail" class="mb-3"/>
        <FormInput v-model="subject" :errors="errors.subject" :disabled="waiting" name="subject" label="Objet" placeholder="Objet" class="mb-3"/>
        <FormInput v-model="message" :errors="errors.message" :disabled="waiting" name="message" label="Message" type="textarea" placeholder="Saisissez votre message..." class="mb-3"/>
      </div>
    </div>
    <div slot="footer" class="text-right">
      <button type="button" class="mr-3 px-3 py-3 text-grey-dark hover:text-grey no-underline font-semibold" @click="hide">
        <span v-if="sent">Fermer</span>
        <span v-else>Annuler</span>
      </button>
      <button v-if="!serverError && !sent" :disabled="waiting" type="button" class="px-3 py-3 w-32 rounded text-white bg-orange hover:bg-orange-light no-underline font-semibold" @click="onSubmit">
        <span v-if="waiting">En cours</span>
        <span v-else>Envoyer</span>
      </button>
    </div>
  </modal>
</template>

<script>
import contact from '../api/contact'
import Modal from './Modal'
import FormInput from './FormInput'

export default {
  components: {
    Modal,
    FormInput
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
      errors: {},
      sent: false,
      waiting: false
    }
  },

  mounted () {
    this.subject = this.initialSubject
    this.message = this.initialMessage
  },

  methods: {
    hide () {
      this.$modal.hide('contact-modal')
    },
    onSubmit () {
      this.waiting = true
      contact.send({
        name: this.name,
        email: this.email,
        subject: this.subject,
        message: this.message
      })
        .then(() => {
          this.sent = true
        })
        .catch((error) => {
          if (error.response) {
            if (error.response.status === 422) {
              this.errors = error.response.data.errors
            } else {
              this.serverError = true
            }
          } else if (error.request) { // error with the request, like network error
            this.serverError = true
          }
        })
        .finally(() => {
          this.waiting = false
        })
    }
  }
}
</script>

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
        <div class="mb-3">
          <label class="block font-semibold text-grey-darkest mb-2" for="name">Nom</label>
          <input id="name" v-model="name" :disabled="waiting" class="w-full p-2 rounded border border-orange-light" type="text" placeholder="Nom">
          <div v-if="errors" class="text-red-light text-sm mt-2">
            <span v-for="(err, index) in errors.errors.name" :key="index">{{ err }} </span>
          </div>
        </div>
        <div class="mb-3">
          <label class="block font-semibold text-grey-darkest mb-2" for="email">E-mail</label>
          <input id="email" v-model="email" :disabled="waiting" class="w-full p-2 rounded border border-orange-light" type="email" placeholder="E-mail">
          <div v-if="errors" class="text-red-light text-sm mt-2">
            <span v-for="(err, index) in errors.errors.email" :key="index">{{ err }} </span>
          </div>
        </div>
        <div class="mb-3">
          <label class="block font-semibold text-grey-darkest mb-2" for="subject">Objet</label>
          <input id="subject" v-model="subject" :disabled="waiting" class="w-full p-2 rounded border border-orange-light" type="text" placeholder="Objet">
          <div v-if="errors" class="text-red-light text-sm mt-2">
            <span v-for="(err, index) in errors.errors.subject" :key="index">{{ err }} </span>
          </div>
        </div>
        <div class="mb-3">
          <label class="block font-semibold text-grey-darkest mb-2" for="message">Message</label>
          <textarea id="message" v-model="message" :disabled="waiting" class="w-full p-2 rounded border border-orange-light" placeholder="Saisissez votre message..." rows="3"/>
          <div v-if="errors" class="text-red-light text-sm mt-2">
            <span v-for="(err, index) in errors.errors.message" :key="index">{{ err }} </span>
          </div>
        </div>
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
              this.errors = error.response.data
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

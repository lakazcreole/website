<template>
  <modal name="shop-closed-modal" class="font-sans text-grey-darker">
    <div slot="header" class="text-2xl text-orange mb-3">Commande indisponible</div>
    <div slot="body">
      <div v-if="serverError">
        Une erreur s'est produite, veuillez réessayer plus tard.
      </div>
      <div v-else>
        <p class="mb-5">
          La Kaz Créole est en déplacement professionnel à La Réunion. Veuillez nous excuser pour la gêne occasionnée.
        </p>
        <div class="mb-5">
          <Alert v-if="sent" color="green">
            Merci ! Vous recevrez votre code promotionnel à l'adresse <span class="font-semibold">{{ email }}</span>.
          </Alert>
          <div v-else>
            Laissez-nous votre e-mail pour bénéficier d'une promotion à notre retour !
            <FormInput v-model="email" :errors="errors.email" :disabled="waiting" name="email" label="E-mail" type="email" placeholder="Entrez votre adresse e-mail" class="mt-3"/>
          </div>
        </div>
        <p class="mb-5">
          <span class="font-semibold">Les commandes reprendront dès le 6 novembre 2018.</span> À très vite !
        </p>
      </div>
    </div>
    <div slot="footer" class="text-right">
      <button type="button" class="mr-3 px-3 py-3 text-grey-dark hover:text-grey no-underline font-semibold" @click="hide">
        Fermer
      </button>
      <button v-show="!serverError && !sent" :disabled="waiting" type="button" class="px-3 py-3 w-32 rounded text-white bg-orange hover:bg-orange-light no-underline font-semibold" @click="onSubmit">
        <span v-show="waiting">En cours</span>
        <span v-show="!waiting">Envoyer</span>
      </button>
    </div>
  </modal>
</template>

<script>
import contact from '../api/contact'

import Modal from './Modal'
import Alert from './Alert'
import FormInput from './FormInput'
import PrimaryButton from './PrimaryButton'

export default {
  components: {
    Modal,
    Alert,
    FormInput,
    PrimaryButton
  },

  data () {
    return {
      email: '',
      errors: {},
      sent: false,
      waiting: false,
      serverError: false
    }
  },

  methods: {
    hide () {
      this.$modal.hide('shop-closed-modal')
    },
    onSubmit () {
      this.waiting = true
      contact.send({
        name: 'Anonyme',
        email: this.email,
        subject: 'Code promotionnel festival interceltique',
        message: `Nouvel inscrit : ${this.email}`
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

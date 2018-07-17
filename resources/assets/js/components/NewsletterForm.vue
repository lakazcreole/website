<template>
  <div class="text-center">
    <p v-if="serverError">Une erreur s'est produite. Veuillez réessayer plus tard.</p>
    <div v-else >
      <p v-if="subscribed">Vous êtes maintenant abonné(e) à notre newsletter. Merci !</p>
      <div v-else>
        <p class="text-center mb-5">
          Pour suivre le projet et recevoir nos actualités, inscrivez-vous à la newsletter !
        </p>
        <form class="py-2" @submit.prevent="onSubmit">
          <div class="flex justify-center">
            <div class="mx-3">
              <input id="email" v-model="email" :disabled="waiting" class="p-2 rounded" type="email" placeholder="Entrez votre email">
              <div v-if="errors" class="flex text-red-light text-sm mt-2">
                <span v-for="(err, index) in errors.errors.email" :key="index">{{ err }} </span>
              </div>
            </div>
            <button :disabled="waiting" type="submit" class="mx-3 px-3 py-2 w-32 font-semibold rounded text-white bg-orange hover:bg-orange-light mb-auto">
              <span v-if="waiting">En cours...</span>
              <span v-else>Inscription</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import newsletter from '../api/newsletter'

export default {
  data () {
    return {
      email: '',
      errors: null,
      subscribed: false,
      serverError: false,
      waiting: false
    }
  },

  methods: {
    onSubmit () {
      this.waiting = true
      newsletter.subscribe(this.email)
        .then(() => {
          this.subscribed = true
        })
        .catch((error) => {
          if (error.status === 422) {
            this.errors = error.data
          } else {
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

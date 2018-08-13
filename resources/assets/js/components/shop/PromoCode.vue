<template>
  <div>
    <div v-if="addMode">
      <label for="code" class="block font-semibold text-grey-darker text-sm mb-2">Code promotionnel</label>
      <div class="flex">
        <input
          v-model="code"
          :disabled="waiting"
          type="text"
          name="code"
          placeholder="Code promotionnel"
          class="w-full p-2 rounded-l border border-orange-lighter text-grey-darker"
        >
        <button :disabled="waiting" :class="`group px-3 border rounded-r border-l-0 border-orange-lighter ${buttonClass}`" @click="onSubmit">
          <i :class="`material-icons ${iconClass}`">check</i>
        </button>
      </div>
      <div v-show="invalidCode" class="mt-2 text-sm text-red-light">Ce code promotionnel est erroné.</div>
    </div>
    <button v-else class="px-3 py-2 border border-green-light rounded text-green-light hover:bg-green-light hover:text-grey-lightest w-full uppercase" @click="addMode = true">
      Code promo
    </button>
  </div>
</template>

<script>
import promoCode from '../../api/promoCode'
import FormInput from '../FormInput'

export default {
  components: {
    FormInput
  },

  data () {
    return {
      addMode: false,
      code: '',
      isValid: false,
      invalidCode: false,
      waiting: false,
      errors: {},
      serverError: false
    }
  },

  computed: {
    buttonClass () {
      return this.waiting ? 'cursor-not-allowed' : 'hover:bg-orange-light hover:border-orange-light'
    },
    iconClass () {
      return this.waiting ? 'text-orange-lighter' : 'text-orange group-hover:text-grey-lightest'
    }
  },

  methods: {
    onSubmit () {
      this.waiting = true
      promoCode.validate(this.code)
        .then(response => response.data)
        .then(data => {
          if (data.is_valid) {
            this.isValid = true
          } else {
            this.invalidCode = true
          }
        })
        .catch((error) => {
          if (error.response) {
            if (error.response.status === 404) {
              this.invalidCode = true
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

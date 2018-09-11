<template>
  <div v-if="serverError" class="text-sm">
    Erreur serveur. Veuillez réessayer plus tard.
  </div>
  <div v-else>
    <button v-show="!discount && !addMode" class="add px-3 py-2 border border-green-light rounded text-green-light hover:bg-green-light hover:text-grey-lightest w-full uppercase" @click="addMode = true">
      Code promo
    </button>
    <div v-if="discount">
      <div>
        <div class="font-semibold text-green-light">Code promotionnel</div>
        <div class="text-sm mt-3 text-green-light">{{ discount.description }}</div>
      </div>
      <Alert v-show="showAlert" color="orange" class="flex mt-3">
        Pour que la promotion soit validée, votre panier doit inclure un des produits concernés.
        <InformationTooltip :content="`${discountProducts}`" class="ml-auto flex-none my-auto inline-block border border-orange-darkest text-orange-darkest w-6 h-6 rounded-full text-center text-sm font-semibold italic"/>
      </Alert>
    </div>
    <div v-show="!discount && addMode">
      <label for="code" class="block font-semibold text-grey-darker text-sm mb-2">Code promotionnel</label>
      <form class="flex" @submit.prevent="onSubmit">
        <input
          v-model="code"
          :disabled="waiting"
          type="text"
          name="code"
          placeholder="Code promotionnel"
          class="w-full p-2 rounded-l border border-orange-lighter text-grey-darker"
        >
        <button :disabled="waiting" :class="`group px-3 border rounded-r border-l-0 border-orange-lighter ${buttonClass}`" type="submit">
          <i :class="`material-icons ${iconClass}`">check</i>
        </button>
      </form>
      <div v-show="invalidCode" class="mt-2 text-sm text-red-light">Ce code promotionnel est erroné.</div>
    </div>
  </div>
</template>

<script>
import discount from '../../api/discount'
import Alert from '../Alert'
import FormInput from '../FormInput'
import InformationTooltip from '../InformationTooltip'

export default {
  components: {
    Alert,
    FormInput,
    InformationTooltip
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
    },
    discount () {
      return this.$store.state.order.discount
    },
    showAlert () {
      return !this.$store.getters['cart/hasDiscountRequiredProducts']
    },
    discountProducts () {
      return this.discount.items.reduce((acc, item) => {
        return acc.concat(item.products)
      }, []).map(product => {
        return product.name
      }).filter(function (value, index, self) {
        return self.indexOf(value) === index
      }).join(', ')
    }
  },

  methods: {
    onSubmit () {
      this.waiting = true
      discount.validateCode(this.code)
        .then(response => response.data)
        .then(data => {
          if (data.is_valid) {
            this.isValid = true
            this.$store.commit('order/setPromoCode', this.code)
            discount.get(data.discount_id)
              .then(response => response.data)
              .then(data => {
                this.$store.commit('order/setDiscount', data)
              })
              .catch(err => {
                console.log(err)
                this.serverError = true
              })
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

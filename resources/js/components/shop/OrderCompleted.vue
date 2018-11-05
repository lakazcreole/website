<template>
  <div>
    <h1 class="text-center text-grey-lightest font-title font-normal text-5xl mb-10" style="text-shadow: 2px 2px 3px black">Commande effectuée !</h1>
    <div class="bg-grey-lightest rounded-lg shadow-lg p-5">
      <h2 class="uppercase font-semibold text-grey text-base  mb-5">Livraison</h2>
      <div class="mb-5 text-grey-darker flex items-center">
        <i class="material-icons text-grey">place</i>
        <div class="ml-2">{{ address }}</div>
      </div>
      <div class="flex mb-5 text-grey-darker">
        <div class="w-1/2 flex items-center">
          <i class="material-icons text-grey">date_range</i>
          <div class="ml-2">{{ date }}</div>
        </div>
        <div class="w-1/2 flex items-center">
          <i class="material-icons text-grey">schedule</i>
          <div class="ml-2">{{ order.time }}</div>
        </div>
      </div>
      <h2 class="uppercase font-semibold text-grey text-base  mt-8 mb-5">Détail de la commande</h2>
      <CartItem
        v-for="(line, index) in order.lines"
        :id="index"
        :name="line.name"
        :price="line.unit_price"
        :quantity="line.quantity"
        :key="index"
        class="mt-3"
      />
      <div class="flex text-grey mt-3">
        <div class="font-semibold">Frais de livraison</div>
        <div class="ml-auto text-sm">
          <span v-if="order.delivery_price">{{ deliveryPriceInFrench }} €</span>
          <span v-else>Offert</span>
        </div>
      </div>
      <div v-for="(apply, index) in order.discount_applies" :key="index" class="flex text-grey mt-3">
        <div class="font-semibold text-green-light">
          {{ apply.product.name }}
          <span v-if="apply.discount_item.percent == 100"> gratuit</span>
          <span v-else> -{{ apply.discount_item.percent }}%</span>
        </div>
        <div class="ml-auto text-sm text-green-light">
          -{{ (apply.discount_item.percent * apply.product.price / 100).toFixed(2).toString().replace('.', ',') }} €
        </div>
      </div>
      <div class="flex text-grey-darker mt-3 font-semibold">
        <div class="font-semibold">Total</div>
        <div class="ml-auto text-sm">{{ finalPriceInFrench }} €</div>
      </div>
      <Alert color="green" class="mt-8">
        Vous recevez la confirmation de votre commande à l'adresse <span class="font-semibold">{{ order.customer.email }}</span>.
      </Alert>
    </div>
  </div>
</template>

<script>
import Alert from '../Alert'
import CartItem from './CartItem'

export default {
  components: {
    Alert,
    CartItem
  },

  props: {
    order: {
      type: Object,
      required: true
    }
  },

  computed: {
    address () {
      let adr = this.order.address.address1
      if (this.order.address.address2) adr += ` ${this.order.address.address2}`
      adr += `, ${this.order.address.zip} ${this.order.address.city}`
      return adr
    },
    date () {
      const date = new Date(this.order.date)
      return date.toLocaleDateString('fr-FR', { weekday: 'short', month: 'long', day: 'numeric' })// .replace(/^\w/, c => c.toUpperCase())
    },
    deliveryPriceInFrench () {
      return this.order.delivery_price.toFixed(2).toString().replace('.', ',')
    },
    finalPriceInFrench () {
      return this.order.final_price.toFixed(2).toString().replace('.', ',')
    }
  }
}
</script>

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
          <div class="ml-2">{{ date.replace(/^\w/, c => c.toUpperCase()) }}</div>
        </div>
        <div class="w-1/2 flex items-center">
          <i class="material-icons text-grey">schedule</i>
          <div class="ml-2">{{ time }}</div>
        </div>
      </div>
      <h2 class="uppercase font-semibold text-grey text-base  mt-8 mb-5">Détail de la commande</h2>
      <CartItem
        v-for="(item, index) in items"
        :id="item.id"
        :name="item.name"
        :price="item.price"
        :quantity="item.quantity"
        :key="index"
        class="mt-3"
        @remove="remove(item)"
      />
      <div class="flex text-grey mt-3">
        <div class="font-semibold">Frais de livraison</div>
        <div class="ml-auto text-sm">
          <span v-if="deliveryPrice">{{ deliveryPriceInFrench }} €</span>
          <span v-else>Offert</span>
        </div>
      </div>
      <div class="flex text-grey-darker mt-3 font-semibold">
        <div class="font-semibold">Total</div>
        <div class="ml-auto text-sm">{{ fullPriceInFrench }} €</div>
      </div>
      <Alert color="green" class="mt-8">
        Vous recevez la confirmation de votre commande à l'adresse <span class="font-semibold">{{ customer.email }}</span>.
      </Alert>
    </div>
  </div>
</template>

<script>
import { mapState, mapGetters } from 'vuex'

import Alert from '../Alert'
import CartItem from './CartItem'

export default {
  components: {
    Alert,
    CartItem
  },

  computed: {
    ...mapGetters('cart', [
      'items',
      'totalPrice',
      'deliveryPrice'
    ]),
    ...mapState('order', [
      'time',
      'customer'
    ]),
    ...mapGetters('order', [
      'address',
      'date'
    ]),
    deliveryPriceInFrench () {
      return this.deliveryPrice.toFixed(2).toString().replace('.', ',')
    },
    fullPriceInFrench () {
      return (this.totalPrice + this.deliveryPrice).toFixed(2).toString().replace('.', ',')
    }
  }
}
</script>

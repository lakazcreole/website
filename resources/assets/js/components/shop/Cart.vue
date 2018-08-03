<template>
  <div>
    <div class="flex mb-5">
      <h2 class="uppercase font-semibold text-grey text-base tracking-wide">Panier</h2>
      <button v-show="!editable" title="Modifier" class="ml-auto text-orange-lighter hover:text-orange flex" @click="edit">
        <i class="material-icons text-lg">edit</i>
      </button>
    </div>
    <div class="rounded-lg bg-white overflow-hidden shadow-lg text-grey-darker">
      <div class="px-4 pt-4">
        <div v-show="items.length">
          <transition-group name="fadeRight">
            <CartItem
              v-for="(item, index) in items"
              :id="item.id"
              :name="item.name"
              :price="item.price"
              :quantity="item.quantity"
              :editable="editable"
              :key="index"
              class="mb-6"
              @remove="remove(item)"
            />
          </transition-group>
          <div class="text-grey mb-5 delivery">
            <div class="flex items-end">
              <div>
                <div class="font-semibold">Frais de livraison</div>
                <div v-show="deliveryPrice > 0" class="text-sm mt-3">Offert à partir de 15 € de commande (hors frais).</div>
              </div>
              <div class="ml-auto mb-auto text-sm flex-no-shrink">
                <div v-show="deliveryPrice === 0">Offert</div>
                <div v-show="deliveryPrice">
                  {{ deliveryPriceInFrench }} €
                </div>
              </div>
            </div>
          </div>
          <Alert v-show="items.length > 0 && !minimumReached" color="red" class="my-5">
            <p>Minimum de commande (8 €) non atteint.</p>
          </Alert>
          <slot/>
        </div>
        <div v-show="items.length === 0" class="mb-3">
          Votre panier est vide.
        </div>
      </div>
      <div class="bg-grey-lighter px-4 py-5">
        <div class="flex items-end">
          <div class="font-semibold">Total</div>
          <div class="ml-auto text-sm">{{ fullPriceInFrench }} €</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import Alert from '../Alert'
import CartItem from './CartItem'

export default {
  components: {
    Alert,
    CartItem
  },

  props: {
    editable: {
      type: Boolean,
      required: true
    }
  },

  computed: {
    ...mapGetters('cart', [
      'items',
      'totalPrice',
      'deliveryPrice',
      'minimumReached'
    ]),
    deliveryPriceInFrench () {
      return this.deliveryPrice.toFixed(2).toString().replace('.', ',')
    },
    fullPriceInFrench () {
      return (this.totalPrice + this.deliveryPrice).toFixed(2).toString().replace('.', ',')
    }
  },

  methods: {
    edit () {
      this.$emit('edit')
    },
    remove (item) {
      this.$store.dispatch('cart/removeProduct', item.id)
    }
  }
}
</script>

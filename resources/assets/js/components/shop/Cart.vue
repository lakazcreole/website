<template>
  <div>
    <div class="flex mx-3 mb-5">
      <h2 class="uppercase font-semibold text-grey text-base tracking-normal">Panier</h2>
      <!--       <button v-show="editable" title="Modifier" class="ml-auto text-orange-lighter hover:text-orange flex">
        <i class="material-icons text-lg">edit</i>
      </button> -->
    </div>
    <div class="rounded-lg bg-white overflow-hidden shadow-lg mx-3 text-grey-darker">
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
                <div class="font-semibold">Livraison</div>
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
    <div v-show="items.length > 0 && !minimumReached" class="minimum-warning text-red-light text-sm mx-3 p-4 mb-3">
      Minimum de commande (8 €) non atteint.
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import CartItem from './CartItem'

export default {
  components: {
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
      'items'
    ]),
    totalPrice () {
      return this.items.reduce((accumulator, item) => accumulator + item.quantity * item.price, 0)
    },
    deliveryPrice () {
      if (this.totalPrice === 0 || this.totalPrice >= 15) return 0
      else if (this.totalPrice <= 13) return 2
      else return 15 - this.totalPrice
    },
    minimumReached () {
      return this.totalPrice + this.deliveryPrice >= 8
    },
    deliveryPriceInFrench () {
      return this.deliveryPrice.toFixed(2).toString().replace('.', ',')
    },
    fullPriceInFrench () {
      return (this.totalPrice + this.deliveryPrice).toFixed(2).toString().replace('.', ',')
    }
  },

  methods: {
    remove (item) {
      this.$store.dispatch('cart/removeProduct', item.id)
    }
  }
}
</script>

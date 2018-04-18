<script>
import CartItem from './CartItem'

export default {
  components: {
    CartItem
  },

  props: {
    items: {
      type: Array,
      required: true
    },
    editable: {
      type: Boolean,
      required: true
    }
  },

  computed: {
    totalPrice() {
        return this.items.reduce((accumulator, item) => accumulator + item.quantity * item.price, 0)
    },
    deliveryCost() {
      if (this.totalPrice === 0 || this.totalPrice >= 15) return 0
      else if (this.totalPrice <= 13) return 2
      else return 15 - this.totalPrice
    },
    fullPrice() {
      return this.totalPrice + this.deliveryCost
    }
  },

  methods: {
    remove(id) {
      this.$emit('removeItem', id)
    },
    edit() {
      this.$emit('edit')
    },
    validate() {
      this.$emit('validate')
    }
  }
}
</script>

<template>
  <div class="order-cart">
    <div class="d-flex justify-content-between align-items-center">
      <h2>Panier</h2>
      <button v-if="!editable" class="edit btn btn-link" @click="edit">Modifier</button>
    </div>
    <div class="card">
      <div v-if="items.length === 0" class="card-header">
        Votre panier est vide.
      </div>
      <div v-else>
        <ul class="list-group list-group-flush">
          <li v-for="(item, index) in items" :key="index" class="list-group-item">
            <CartItem :ref="`cartItem${index}`" :id="item.id" :name="item.name" :price="item.price" :quantity="item.quantity" :editable="editable" @remove="remove"></CartItem>
          </li>
          <li class="delivery list-group-item">
            <div v-if="totalPrice < 15">
              <div class="d-flex flex-row align-items-center">
                Livraison<span class="ml-auto">{{ deliveryCost.toFixed(2).toString().replace('.', ',') }} €</span>
              </div>
              <small>Offert à partir de 15 € de commande (hors frais).</small>
            </div>
            <div v-else>
              <div class="d-flex flex-row align-items-center">
                Livraison <small class="ml-auto">Offert</small>
              </div>
            </div>
          </li>
          <li v-if="fullPrice < 8" class="list-group-item">
            <div class="text-danger">
              Minimum de commande (8 €) non atteint.
            </div>
          </li>
        </ul>
      </div>
      <div class="total card-footer d-flex flex-row align-items-center">
        Total : <span class="ml-auto">{{ fullPrice.toFixed(2).toString().replace('.', ',') }} €</span>
      </div>
    </div>
    <slot name="info"></slot>
    <button v-if="editable" class="validate btn btn-lg btn-block btn-primary mt-3" :disabled="items.length === 0 || fullPrice < 8" @click="validate">Commander</button>
  </div>
</template>

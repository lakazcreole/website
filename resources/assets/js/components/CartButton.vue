<template>
  <button
    class="btn btn-rounded btn-lg btn-primary"
    @click="$emit('click')"
  >
    <!-- <span v-show="items.length" class="badge badge-pill badge-light mr-2 px-2 py-1">{{ items.length }}</span> -->
    Commande
    <small v-show="items.length" class="ml-2 py-2">{{ fullPrice.toFixed(2).toString().replace('.', ',') }} €</small>
  </button>
</template>

<script>
export default {
  props: {
    items: {
      type: Array,
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
  }
}
</script>

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
      if (this.totalPrice === 0 || this.totalPrice >= 15) return 0
      else if (this.totalPrice <= 13) return 2
      else return 15 - this.totalPrice
    },
    fullPrice() {
      return this.totalPrice + this.deliveryCost
    }
  },
  methods: {
    remove(item) {
      this.$emit('remove', item)
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
  <div>
    <button class="edit" @click="edit">Modifier</button>
    <ul>
      <li v-for="(item, index) in items" :key="index">
        {{ item.quantity }} {{ item.name }} <button class="remove" @click="remove(item, index)">&times;</button>
      </li>
      <li v-if="totalPrice < 15" class="delivery">
        Livraison <span class="ml-auto">{{ deliveryCost.toFixed(2).toString().replace('.', ',') }} €</span>
        <small>Offert à partir de 15 € de commande (hors frais).</small>
      </li>
      <li v-else class="delivery">
        Livraison <small class="ml-auto">Offert</small>
      </li>
      <li v-if="totalPrice < 8">
        Minimum de commande (8 €) non atteint.
      </li>
    </ul>
    <div class="total">
      Total : <span class="ml-auto">{{ fullPrice.toFixed(2).toString().replace('.', ',') }} €</span>
    </div>
    <button class="validate" @click="validate">Commander</button>
  </div>
</template>

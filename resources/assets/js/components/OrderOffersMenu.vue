<template>
  <div>
    <h2 class="mb-4">Offres du moment</h2>
    <div class="card-deck mb-5">
      <OrderOffer
        v-for="product in products"
        :id="product.id" :name="product.name" :price="Number(product.price)" :img-src="product.imageUrl" :description="product.description"
        @add="add(product)"
        :key="product.id"
      />
    </div>
  </div>
</template>

<script>
import OrderOffer from './OrderOffer'

export default {
  components: {
    OrderOffer
  },

  props: {
    products: {
      type: Array,
      required: true
    }
  },

  methods: {
    add (product) {
      this.$emit('addProduct', product)
    }
  }
}
</script>

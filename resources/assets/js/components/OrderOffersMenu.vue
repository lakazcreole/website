<template>
  <div>
    <h2 class="mb-4">Offres du moment</h2>
    <div class="row mb-5">
      <div v-for="offer in offers" class="col-md-4" :key="offer.id">
        <OrderOffer
          :id="offer.product.id" :name="offer.product.name" :price="Number(offer.product.price)" :img-src="offer.imageUrl" :description="offer.product.description"
          @add="add(offer.product)"
        />
      </div>
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
    offers: {
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

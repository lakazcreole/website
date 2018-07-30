<template>
  <div v-if="loaded && offers.length">
    <h2 class="mx-3 mb-5 uppercase font-semibold text-grey text-base tracking-normal">Offres du moment</h2>
    <div class="flex flex-wrap justify-around">
      <div v-for="(offer, index) in offers" :class="`w-full sm:w-1/2 md:w-1/3 mb-3 md:mb-0 px-3`" :key="index">
        <OffersListItem
          :product-id="offer.product.id"
          :product-name="offer.product.name"
          :product-price="Number(offer.product.price)"
          :product-description="offer.product.description"
          :img-src="offer.imageUrl"
          @add="add(offer.product)"
        />
      </div>
    </div>
  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex'
import OffersListItem from './OffersListItem'

export default {
  components: {
    OffersListItem
  },

  computed: {
    ...mapState('products', {
      offers: 'offers',
      loaded: 'loadedOffers'
    })
  },

  methods: {
    ...mapActions('cart', {
      add: 'addProduct'
    })
  }
}
</script>

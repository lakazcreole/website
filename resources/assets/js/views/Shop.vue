<template>
  <div>
    <div :class="`z-40 sticky pin-t shrink-transition ${headerHeightClass} shadow-md`">
      <div class="z-0 w-full h-full" style="background-image: url('/images/order_header.jpg'); background-size: cover; background-position: center"/>
      <div class="absolute pin-t z-0 bg-black opacity-25 w-full h-full"/>
      <!-- Delivery input modal -->
      <div class="absolute pin-t mt-10 w-full flex justify-center">
        <div class="mx-3 sm:mx-0 max-w-xs sm:max-w-sm w-full font-main">
          <h1 class="text-center text-grey-lightest font-title font-normal text-5xl mb-3" style="text-shadow: 2px 2px 3px black">Commande</h1>
          <DeliveryInput
            @filled="inputFilled"
            @editingAddress="editingAddress = showMenu"
            @editedAddress="editingAddress = false"
          />
        </div>
      </div>
    </div>
    <transition name="slide" enter-active-class="slideInUp" leave-active-class="slideOutDown">
      <div v-show="showMenu" class="py-20 md:py-16">
        <OffersList/>
        <div class="h-64">
          Things
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import VueSticky from 'vue-sticky'

import DeliveryInput from '../components/shop/DeliveryInput'
import OffersList from '../components/shop/OffersList'

export default {
  components: {
    DeliveryInput,
    OffersList
  },

  directives: {
    'sticky': VueSticky
  },

  data () {
    return {
      showMenu: false,
      editingAddress: false
    }
  },

  computed: {
    ...mapGetters('order', [
      'deliveryInputFilled'
    ]),
    headerHeightClass () {
      if (this.showMenu) {
        // editing datetime
        if (!this.deliveryInputFilled) return 'h-82vh sm:h-67vh lg:h-52vh xl:h-42vh'
        // editing address
        if (this.editingAddress) return 'h-53vh lg:h-34vh'
        // not editing
        return 'h-34vh md:h-22vh lg:h-24vh'
      }
      // Values when menu is not shown
      return this.deliveryInputFilled ? 'h-20vh' : 'h-82vh md:h-52vh xl:h-58vh' // sm:h-70vh
    }
  },

  mounted () {
    this.$store.dispatch('products/fetchProducts')
    this.$store.dispatch('products/fetchOffers')
  },

  methods: {
    inputFilled () {
      this.showMenu = true
    }
  }
}
</script>

<style lang="scss">
.shrink-transition {
  transition: height 0.8s ease;
}

.slide-transition {
  transition: margin 0.8s ease;
}
</style>

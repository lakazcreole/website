<template>
  <div class="">
    <transition enter-active-class="fadeInRight" leave-active-class="fadeOutRight" duration="800">
      <div v-show="showMobileCart" :class="`shrink-transition overflow-hidden ${drawerWidthClass} bg-black text-white`">
        <Cart :editable="editingCart"/>
      </div>
    </transition>
    <transition enter-active-class="fadeInLeft" leave-active-class="fadeOutLeft" duration="800">
      <div v-show="!showMobileCart" :class="`shrink-transition ${contentWidthClass}`" >
        <div :class="`z-30 sticky pin-t shrink-transition ${headerHeightClass} shadow-md`">
          <div class="z-0 w-full h-full" style="background-image: url('/images/order_header.jpg'); background-size: cover; background-position: center"/>
          <div class="absolute pin-t z-0 bg-black opacity-25 w-full h-full"/>
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
          <div v-show="showMenu" class="container mx-auto py-20 md:py-16">
            <OffersList/>
            <div class="flex mt-8 justify-end">
              <div class="hidden sm:block flex-1">
                <ProductsListNav class="sticky mr-5 " style="top: 250px"/>
              </div>
              <div class="w-full sm:max-w-sm flex-none">
                <ProductsList/>
              </div>
              <div class="hidden sm:block flex-1">
                <Cart :editable="editingCart" class="sticky ml-5 mr-3" style="top: 250px"/>
              </div>
            </div>
          </div>
        </transition>
      </div>
    </transition>
  </div>
</template>

<script>
import { mapState, mapGetters } from 'vuex'
import VueSticky from 'vue-sticky'

import DeliveryInput from '../components/shop/DeliveryInput'
import ProductsList from '../components/shop/ProductsList'
import ProductsListNav from '../components/shop/ProductsListNav'
import OffersList from '../components/shop/OffersList'
import Cart from '../components/shop/Cart'

export default {
  components: {
    DeliveryInput,
    ProductsList,
    ProductsListNav,
    OffersList,
    Cart
  },

  directives: {
    'sticky': VueSticky
  },

  data () {
    return {
      showMenu: false,
      editingAddress: false,
      editingCart: true
    }
  },

  computed: {
    ...mapState('order', [
      'showMobileCart'
    ]),
    ...mapGetters('order', [
      'deliveryInputFilled'
    ]),
    contentWidthClass () {
      return this.showMobileCart ? 'h-0' : 'h-full'
    },
    drawerWidthClass () {
      return this.showMobileCart ? 'h-82vh md:h-52vh xl:h-58vh py-10' : 'h-0'
    },
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
    this.$store.dispatch('products/fetchTypes')
    this.$store.dispatch('order/fetchDeliveryDays')
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
  transition: height 0.8s ease,
              width 0.8s ease,
              padding 0.8s ease;
}

.slide-transition {
  transition: margin 0.8s ease;
}
</style>

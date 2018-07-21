<template>
  <div>
    <div :class="`relative shrink-transition ${headerHeightClass}`">
      <div class="z-0 w-full h-full" style="background-image: url('/images/order_header.jpg'); background-size: cover; background-position: center"/>
      <div class="absolute pin-t z-0 bg-black opacity-25 w-full h-full"/>
    </div>
    <div class="relative font-main">
      <div :class="`absolute w-full flex justify-center ${headerMarginClass} slide-transition`">
        <div class="mx-3 sm:mx-0 max-w-xs sm:max-w-sm w-full">
          <h1 class="text-center text-grey-lightest font-title font-normal text-5xl mb-3" style="text-shadow: 2px 2px 3px black">Commande</h1>
          <DeliveryInput @filled="inputFilled" @editingAddress="editingAddress = showMenu" @editedAddress="editingAddress = false"/>
        </div>
      </div>
      <transition name="slide" enter-active-class="slideInUp" leave-active-class="slideOutDown">
        <div v-show="showMenu" class="py-20">
          Yo
        </div>
      </transition>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import DeliveryInput from '../components/shop/DeliveryInput'
import orderClass from '../mixins/orderClass'

export default {
  components: {
    DeliveryInput
  },

  mixins: [orderClass],

  data () {
    return {
      showMenu: false,
      editingAddress: false
    }
  },

  computed: {
    ...mapGetters('order', [
      'deliveryInputFilled'
    ])
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

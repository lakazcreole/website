<template>
  <div>
    <div :class="`relative shrink-transition ${heightClass}`">
      <div class="z-0 w-full h-full" style="background-image: url('/images/order_header.jpg'); background-size: cover; background-position: center"/>
      <div class="absolute pin-t z-0 bg-black opacity-25 w-full h-full"/>
    </div>
    <div class="relative font-main">
      <div :class="`absolute w-full flex justify-center ${marginClass} slide-transition`">
        <div class="mx-3 sm:mx-0 max-w-xs sm:max-w-sm w-full">
          <h1 class="text-center text-grey-lightest font-title font-normal text-5xl mb-3" style="text-shadow: 2px 2px 3px black">Commande</h1>
          <DeliveryInput @filled="inputFilled" @editingAddress="editingAddress = showMenu" @editedAddress="editingAddress = false"/>
        </div>
      </div>
      <div class="h-64">
        Yo
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import DeliveryInput from './DeliveryInput'

export default {
  components: {
    DeliveryInput
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
    heightClass () {
      if (this.showMenu) {
        // editing address
        if (this.editingAddress) return 'h-53vh lg:h-34vh'
        // editing datetime
        if (!this.deliveryInputFilled) return 'h-82vh sm:h-67vh lg:h-43vh'
        // not editing
        return 'h-34vh lg:h-20vh'
      }
      // Values when menu is not shown
      return this.deliveryInputFilled ? 'h-20vh' : 'h-82vh lg:h-67vh xl:h-58vh' // sm:h-70vh
    },
    marginClass () {
      if (this.showMenu) {
        // editing address
        if (this.editingAddress) return '-mt-68'
        // editing datetime
        if (!this.deliveryInputFilled) return '-mt-108 sm:-mt-88 lg:-mt-92'
        // not editing
        return '-mt-40'
      }
      // Values when menu is not shown
      return this.deliveryInputFilled ? '-mt-40' : '-mt-112 sm:-mt-108 lg:-mt-104 xl:-mt-120'
    }
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

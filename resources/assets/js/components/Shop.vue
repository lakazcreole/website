<template>
  <div>
    <div class="relative" style="height: 58vh">
      <div class="z-0 w-full h-full" style="background-image: url('/images/order_header.jpg'); background-size: cover; background-position: center"/>
      <div class="absolute pin-t z-0 bg-black opacity-25 w-full h-full"/>
    </div>
    <div class="relative font-main">
      <div class="absolute w-full -mt-120 flex justify-center">
        <div class="mx-3 sm:mx-0 max-w-xs sm:max-w-sm w-full">
          <h1 class="text-center text-grey-lightest font-title font-normal text-5xl mb-3" style="text-shadow: 2px 2px 3px black">Commande</h1>
          <DeliveryInput/>
        </div>
      </div>
      <div class="h-64">
        Yo
      </div>
    </div>
  </div>
</template>

<script>
import DeliveryInput from './DeliveryInput'

export default {
  components: {
    DeliveryInput
  },

  data () {
    return {
    }
  }
}
</script>

<template>
  <div>
    <div class="relative h-64">
      <div class="absolute z-0 w-full h-full" style="background-image: url('/images/order_header.jpg'); background-size: cover; background-position: center"/>
      <div class="absolute z-0 bg-black opacity-25 w-full h-full"/>
    </div>
    <div class="relative">
      <div class="absolute w-full -mt-40 flex justify-center">
        <div class="mx-3 sm:mx-0 max-w-xs sm:max-w-sm w-full">
          <h1 class="text-center text-grey-lightest font-title font-normal text-5xl mb-3" style="text-shadow: 2px 2px 3px black">Commande</h1>
          <div v-show="show">
            <OrderAddressInput v-model="address" @change="val => { data = val }" @submit="show = false"/>
          </div>
          <div v-show="!show" class="bg-white p-4 shadow-lg rounded z-10">
            {{ orderAddress }}
            <!-- <ShopAlert/> -->
          </div>
        </div>
      </div>

      Things
    </div>
  </div>
</template>

<script>
import OrderAddressInput from './OrderAddressInput'
import ShopAlert from './ShopAlert'

export default {
  components: {
    OrderAddressInput,
    ShopAlert
  },

  data () {
    return {
      show: true,
      address: '',
      data: {}
    }
  },

  computed: {
    orderAddress () {
      return this.$store.state.order.address.value
    }
  }
}
</script>

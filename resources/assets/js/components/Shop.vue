<template>
  <div>
    <div class="relative h-64">
      <div class="absolute z-0 w-full h-full" style="background-image: url('/images/order_header.jpg'); background-size: cover; background-position: center"/>
      <div class="absolute z-0 bg-black opacity-25 w-full h-full"/>
    </div>
    <div class="relative">
      <div class="absolute w-full -mt-40 flex justify-center">
        <div class="mx-3 sm:mx-0 max-w-xs sm:max-w-sm">
          <h1 class="text-grey-lightest font-title font-normal text-4xl mb-2">Commande</h1>
          <div class="bg-white p-4 shadow-lg rounded-lg z-10">
            <ShopAlert/>
            <p>
              Things
            </p>
          </div>
        </div>
      </div>

      Things
    </div>
  </div>
</template>

<script>
import ShopAlert from './ShopAlert'

export default {
  components: {
    ShopAlert
  },
  props: {

  },
  data () {
    return {

    }
  }
}
</script>

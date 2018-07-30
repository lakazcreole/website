<template>
  <div class="inline-flex">
    <a :href="url" :class="`${linkClass} text-grey-lightest no-underline px-3 py-2 sm:px-5 sm:py-3 rounded-full border-2 border-orange hover:border-orange-light bg-orange hover:bg-orange-light`">Commander</a>
    <button v-if="order" class="inline-flex sm:hidden rounded-lg border-2 border-orange px-4 py-2 items-center text-orange-light">
      {{ totalInFrench }} € <i class="material-icons text-orange ml-3">shopping_cart</i>
    </button>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  props: {
    url: {
      type: String,
      required: true
    },
    order: {
      type: Boolean,
      required: true
    }
  },

  computed: {
    ...mapGetters('cart', [
      'items',
      'totalPrice'
    ]),
    totalInFrench () {
      return this.totalPrice.toFixed(2).toString().replace('.', ',')
    },
    linkClass () {
      if (!this.order) return 'inline-block'
      return 'hidden sm:inline-block'
    }
  }
}
</script>

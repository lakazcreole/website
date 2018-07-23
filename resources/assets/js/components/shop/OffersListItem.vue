<template>
  <div class="relative flex rounded shadow-lg overflow-hidden group">
    <InformationTooltip
      v-if="productDescription"
      :content="productDescription"
      class="absolute pin-r m-3 bg-grey-lightest text-black w-6 h-6 py-1 rounded-full text-center text-sm font-semibold italic z-10"
    />
    <img :src="imgSrc" :alt="productName" class="h-64">
    <div class="absolute bg-black opacity-25 group-hover:opacity-75 h-full w-full z-0 opacity-transition"/>
    <div class="absolute p-3 h-full w-full flex">
      <div class="mt-auto text-grey-lightest">
        <div class="text-2xl mb-2">{{ productName }}</div>
        <div class="ml-auto my-auto">{{ productPriceInFrench }} €</div>
      </div>
    </div>
    <div class="hidden group-hover:flex absolute h-full w-full">
      <button class="m-auto px-5 py-3 rounded-full text-white border-2 border-orange hover:border-orange-light bg-orange hover:bg-orange-light" @click="add">
        Ajouter
      </button>
    </div>
  </div>
</template>

<script>
import InformationTooltip from '../InformationTooltip'

export default {
  components: {
    InformationTooltip
  },

  props: {
    productId: {
      type: Number,
      required: true
    },
    productName: {
      type: String,
      required: true
    },
    productPrice: {
      type: Number,
      required: true
    },
    productDescription: {
      type: String,
      required: false,
      default: null
    },
    imgSrc: {
      type: String,
      required: true
    }
  },

  computed: {
    productPriceInFrench () {
      return this.productPrice.toFixed(2).toString().replace('.', ',')
    }
  },

  methods: {
    add () {
      this.$emit('add')
    }
  }
}
</script>

<style lang="scss">
.opacity-transition {
  transition: opacity 0.25s ease;
}
</style>

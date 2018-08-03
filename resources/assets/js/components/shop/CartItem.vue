<template>
  <div class="text-grey-darker">
    <div class="flex items-center">
      <div class="w-6 mr-3 quantity">
        <div class="flex w-6 h-6 text-sm rounded-full bg-orange-light text-white font-semibold justify-around p-1">{{ quantity }}</div>
      </div>
      <div :class="nameClass">
        {{ name }}
      </div>
      <div class="ml-auto text-orange-light text-sm price flex-no-shrink">
        <div v-if="price">{{ totalPriceInFrench }} €</div>
        <div v-else>Offert</div>
      </div>
      <button v-show="editable" type="button" class="hover:bg-red-light w-4 h-4 rounded-full text-red-lighter hover:text-grey-lightest ml-3" @click="remove">&times;</button>
    </div>
    <!--     <div class="flex items-center text-grey-light text-sm mt-2">
      <button class="flex text-xs"><i class="material-icons text-grey-light">remove_circle_outline</i></button>
      <span class="font-semibold mx-1">{{ quantity }}</span>
      <button class="flex text-xs"><i class="material-icons text-grey-light">add_circle_outline</i></button>
    </div> -->
  </div>
</template>

<script>
export default {
  props: {
    id: {
      type: Number,
      required: true
    },
    name: {
      type: String,
      required: true
    },
    quantity: {
      type: Number,
      required: true
    },
    price: {
      type: Number,
      required: true
    },
    editable: {
      type: Boolean,
      default: false
    },
    nameClass: {
      type: String,
      default: 'font-semibold'
    }
  },

  computed: {
    totalPriceInFrench () {
      return (this.quantity * this.price).toFixed(2).toString().replace('.', ',')
    }
  },

  methods: {
    remove () {
      this.$emit('remove', this.id)
    }
  }
}
</script>

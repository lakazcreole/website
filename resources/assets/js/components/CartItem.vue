<template>
  <div class="d-flex flex-row align-items-center">
    <span class="quantity badge badge-pill badge-secondary mr-2 px-2 py-1">{{ quantity }}</span> {{ name }}
    <div class="price ml-auto">
      <span v-if="price">{{ (quantity * price).toFixed(2).toString().replace('.', ',') }} €</span>
      <small v-else>Offert</small>
    </div>
    <button v-if="editable" type="button" class="remove text-danger close ml-3" @click="remove">&times;</button>
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
      required: false,
      default: false
    }
  },
  methods: {
    remove() {
      this.$emit('remove')
    }
  }
}
</script>



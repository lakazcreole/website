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
      this.$emit('remove', this.id)
    }
  }
}
</script>

<template>
  <div class="">
    <span class="quantity">{{ quantity }}</span> {{ name }}
    <div class="price">
      <span v-if="price">{{ (quantity * price).toFixed(2).toString().replace('.', ',') }} €</span>
      <small v-else>Offert</small>
    </div>
    <button v-if="editable" type="button" class="remove" @click="remove">&times;</button>
  </div>
</template>



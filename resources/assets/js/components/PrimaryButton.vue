<template>
  <button :disabled="disabled" :class="`px-3 py-3 rounded-full text-grey-lightest ${className}`" @click="onClick">
    <slot/>
  </button>
</template>

<script>
export default {
  props: {
    disabled: {
      type: Boolean,
      default: false
    }
  },

  computed: {
    className () {
      return this.disabled ? 'bg-orange-lighter cursor-not-allowed' : 'bg-orange hover:bg-orange-light'
    }
  },

  methods: {
    onClick () {
      this.$emit('click')
    }
  }
}
</script>

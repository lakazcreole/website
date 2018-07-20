<template>
  <div>
    <div :class="`top bg-white px-4 pt-4 pb-3 shadow-lg rounded-t-lg ${topClass} z-10 flex`">
      <slot name="top"/>
    </div>
    <div :class="`bottom bg-white px-4 pb-4 shadow-lg rounded-b-lg z-20 ${bottomClass} ${splitClass} slide-transition`">
      <slot name="bottom"/>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    split: {
      type: Boolean,
      required: true
    },
    topClass: {
      type: String,
      default: ''
    },
    bottomClass: {
      type: String,
      default: ''
    }
  },

  computed: {
    splitClass () {
      return this.split ? 'rounded-t-lg mt-10 pt-4 opacity-25' : ''
    }
  }
}
</script>

<style lang="scss" scoped>
.slide-transition {
  transition: padding 0.8s ease,
              opacity 0.25s ease,
              height 0.8s ease;
}
</style>

<template>
  <div :class="`border-l-4 border-${color} bg-${color}-lightest px-4 py-2 leading-normal text-${color}-darkest text-sm`">
    <slot/>
  </div>
</template>

<script>
export default {
  props: {
    color: {
      type: String,
      required: true
    }
  }
}
</script>

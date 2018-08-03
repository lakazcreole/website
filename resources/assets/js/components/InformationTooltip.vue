<template>
  <span v-tooltip="content">
    <slot name="default">i</slot>
  </span>
</template>

<script>
import { VTooltip } from 'v-tooltip'

export default {
  directives: {
    'tooltip': VTooltip
  },

  props: {
    content: {
      type: String,
      required: true
    }
  }
}
</script>

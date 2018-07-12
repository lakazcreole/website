<template>
  <form @submit.prevent="handleSubmit()">
    <div class="form-row">
      <div class="col-md-10">
        <DeliveryTimeSelector :on-date-input="handleDateInput" :on-time-input="handleTimeInput"/>
      </div>
      <div class="form-group col-md-2">
        <button v-if="canValidate" type="submit" class="btn btn-primary btn-block">Suivant</button>
        <button v-else class="btn btn-primary btn-block" aria-disabled="true" disabled>Suivant</button>
      </div>
    </div>
  </form>
</template>

<script>
import DeliveryTimeSelector from './DeliveryTimeSelector'

export default {
  components: {
    DeliveryTimeSelector
  },
  props: {
    onDateInput: {
      type: Function,
      required: true
    },
    onTimeInput: {
      type: Function,
      required: true
    }
  },
  data () {
    return {
      date: null,
      time: null
    }
  },
  computed: {
    canValidate () {
      return this.date !== null && this.time !== null
    }
  },
  methods: {
    handleSubmit () {
      this.$emit('submit')
    },
    handleDateInput (value) {
      this.date = value
      this.onDateInput(value)
    },
    handleTimeInput (value) {
      this.time = value
      this.onTimeInput(value)
    }
  }
}
</script>

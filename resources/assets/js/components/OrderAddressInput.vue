<template>
  <input
    ref="input"
    :value="value"
    type="search"
    placeholder="Entrez votre adresse"
    class="inline-block w-full p-2 rounded border-0"
    @input="updateValue($event.target.value)"
    @keyup.enter="submit"
  >
</template>

<script>
import places from 'places.js'

const options = {
  language: 'fr_FR',
  type: 'address',
  countries: ['FR']
}

export default {
  props: {
    value: {
      type: String,
      default: ''
    }
  },

  data () {
    return {
      placesAutocomplete: null
    }
  },

  mounted () {
    options.container = options.container || this.$el
    this.placesAutocomplete = places(options)

    this.placesAutocomplete.on('change', (e) => {
      this.$store.commit('order/setAddress', e.suggestion)
      this.$emit('change', e.suggestion)
      this.updateValue(e.suggestion.value)
    })

    this.placesAutocomplete.on('clear', () => {
      this.$emit('change', {})
      this.updateValue(null)
    })
  },

  beforeDestroy () {
    this.placesAutocomplete.destroy()
  },

  methods: {
    updateValue (value) {
      this.$emit('input', value)
    },
    submit () {
      this.$emit('submit')
    }
  }
}
</script>

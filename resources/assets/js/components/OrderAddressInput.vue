<template>
  <input
    ref="input"
    :value="value"
    :class="className"
    type="search"
    placeholder="Entrez votre adresse"
    @input="updateValue($event.target.value)"
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
    },
    inputClass: {
      type: String,
      default: null
    }
  },

  data () {
    return {
      placesAutocomplete: null
    }
  },

  computed: {
    className () {
      return this.inputClass || 'inline-block w-full p-4 rounded border-0'
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
      this.$emit('change', null)
      this.updateValue(null)
    })
  },

  beforeDestroy () {
    this.placesAutocomplete.destroy()
  },

  methods: {
    updateValue (value) {
      this.$emit('input', value)
    }
  }
}
</script>

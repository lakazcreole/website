<template>
  <div>
    <div class="d-flex flex-row align-items-center">
      {{ name }}
      <span v-tooltip="description" v-if="description" class="info ml-2 badge badge-pill badge-secondary">i</span>
      <span class="ml-auto">{{ price.toString().replace('.', ',') }} €</span>
      <button v-if="options.length" class="expand btn btn-sm btn-outline-primary ml-2" @click="toggle">
        <div class="d-flex align-items-center text-primary">
          <i v-if="!expand" class="material-icons">expand_more</i>
          <i v-else class="material-icons">expand_less</i>
        </div>
      </button>
      <button v-else class="add btn btn-sm btn-outline-primary ml-2" @click="add">
        <div class="d-flex align-items-center text-primary">
          <i class="material-icons">add</i>
        </div>
      </button>
    </div>
    <div v-if="options" v-show="expand" class="expandable">
      <div v-for="(option, index) in options" :key="index" class="input-group my-3">
        <div class="input-group-prepend">
          <label :for="`select-option-${option.name}`" class="input-group-text">{{ option.name }}</label>
        </div>
        <select v-model="optionValues[index]" :id="`select-option-${option.name}`" class="custom-select">
          <option :value="0" selected>Aucun</option>
          <option v-for="product in option.products" :value="product.id" :key="product.id">
            {{ product.name }}
          </option>
        </select>
      </div>
      <button class="add btn btn-block btn-primary" @click="add">
        Ajouter
      </button>
    </div>
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
    price: {
      type: Number,
      required: true
    },
    description: {
      type: String,
      required: false,
      default: null
    },
    options: {
      type: Array,
      required: false,
      default: function () {
        return []
      }
    }
  },

  data () {
    return {
      expand: false,
      optionValues: []
    }
  },

  mounted () {
    this.options.forEach((option, index) => {
      this.optionValues[index] = 0
    })
  },

  methods: {
    toggle () {
      this.expand = !this.expand
      if (this.expand) {
        this.$emit('expand')
      }
    },
    expandLess () {
      this.expand = false
    },
    add () {
      this.$emit('add', this.id)
      if (this.options.length) {
        this.options.forEach((option, index) => {
          if (this.optionValues[index] !== 0) {
            this.$emit('add', this.optionValues[index])
          }
        })
      }
    }
  }
}
</script>

<template>
  <div class="text-grey-darker">
    <div class="flex items-center">
      <div class="mr-3">
        <span class="font-semibold">{{ name }}</span>
        <div v-if="description" class="text-sm sm:text-base text-grey mt-1 sm:mt-2">{{ description }}</div>
      </div>
      <div class="text-sm ml-auto flex-no-shrink">
        {{ priceInFrench }} €
      </div>
      <div>
        <button v-if="options && options.length" class="expand flex flex-no-grow ml-5 group border border-orange-light hover:bg-orange-light rounded-full p-1" @click="toggle">
          <i v-show="expand" class="material-icons text-orange group-hover:text-grey-lightest">expand_less</i>
          <i v-show="!expand" class="material-icons text-orange group-hover:text-grey-lightest">expand_more</i>
        </button>
        <button v-else class="add flex flex-no-grow ml-5 group border border-orange-light hover:bg-orange-light rounded-full p-1" @click="add">
          <i class="material-icons text-orange group-hover:text-grey-lightest">add</i>
        </button>
      </div>
    </div>
    <div class="overflow-hidden">
      <transition enter-active-class="fadeInDown" leave-active-class="fadeOutUp" duration="500">
        <div v-if="options && options.length" v-show="expand" class="expandable">
          <div v-for="(option, index) in options" :key="index" class="mt-4">
            <div class="flex text-grey-dark">
              <label :for="`option-${option.name}`" class="px-4 py-2 font-semibold rounded-l-full border border-r-0 border-grey-light">
                {{ option.name }}
              </label>
              <select v-model="optionsValue[index]" class="flex-auto px-2 bg-transparent rounded-r-full border border-grey-light text-grey-dark outline-none">
                <option :value="0" selected>Aucun</option>
                <option v-for="product in option.products" :value="product.id" :key="product.id">
                  {{ product.name }}
                </option>
              </select>
            </div>
          </div>
          <button class="add w-full border border-orange-light text-orange hover:bg-orange-light hover:text-grey-lightest rounded-full p-2 mt-4" @click="add">
            Ajouter
          </button>
        </div>
      </transition>
    </div>
  </div>
</template>

<script>
import InformationTooltip from '../InformationTooltip'

export default {
  components: {
    InformationTooltip
  },

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
      default: () => null
    },
    expand: {
      type: Boolean,
      required: true
    }
  },

  data () {
    return {
      optionsValue: []
    }
  },

  computed: {
    priceInFrench () {
      return this.price.toString().replace('.', ',')
    }
  },

  mounted () {
    if (this.options === null) return
    this.options.forEach((option, index) => {
      this.optionsValue[index] = 0
    })
  },

  methods: {
    toggle () {
      this.$emit('expand')
    },
    add () {
      this.$emit('expand')
      this.$emit('add', this.id)
      if (this.options && this.options.length) {
        this.options.forEach((option, index) => {
          if (this.optionsValue[index] !== 0) {
            this.$emit('add', this.optionsValue[index])
          }
        })
      }
    }
  }
}
</script>

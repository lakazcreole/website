<template>
  <div>
    <div v-for="type in types" v-if="shouldDisplay(type.key)" :key="type.key">
      <h2 :id="type.key" class="uppercase font-semibold text-grey text-base tracking-wide mb-5">
        {{ type.name }}
      </h2>
      <div class="bg-white rounded-lg shadow-lg mb-8 p-4">
        <ProductsListItem
          v-for="(product, index) in products.filter(p => p.type === type.key)"
          :id="product.id"
          :name="product.name"
          :price="product.price"
          :description="product.description"
          :options="type.key === 'main' ? mainDishOptions : null"
          :expand="expandedProductId === product.id"
          :key="index"
          :class="index ? 'mt-5' : ''"
          @add="add"
          @expand="expand(product)"
        />
      </div>
    </div>
  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex'
import ProductsListItem from './ProductsListItem'

export default {
  components: {
    ProductsListItem
  },

  data () {
    return {
      expandedProductId: null,
      previousCategories: []
    }
  },

  computed: {
    ...mapState('products', {
      products: 'all',
      types: 'types',
      loaded: 'loadedProducts'
    }),
    mainDishOptions () {
      return [{
        name: 'Sauce',
        products: this.products.filter(product => product.type === 'side')
      }]
    },
    currentCategory: {
      get () {
        return this.$store.state.products.currentCategory
      },
      set (value) {
        this.$store.commit('products/setCurrentCategory', value)
      }
    }
  },

  methods: {
    ...mapActions('cart', {
      addToCart: 'addProduct'
    }),
    add (productId) {
      this.addToCart(this.products.find(product => product.id === productId))
    },
    shouldDisplay (type) {
      return this.products.filter(product => product.type === type).length
    },
    expand (product) {
      if (this.expandedProductId === product.id) {
        this.expandedProductId = null
      } else {
        this.expandedProductId = product.id
      }
    }
  }
}
</script>

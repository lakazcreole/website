<template>
  <div class="row mb-5">
    <div class="d-none d-lg-block col-lg-4 order-nav">
      <div v-sticky="{ zIndex: 1019, stickyTop: 115+38 }">
        Catégories
        <ul class="nav flex-column mt-3">
          <li v-for="type in types" class="nav-item" :key="type.key">
            <a href="#" @click.prevent="scrollToTag(type.key)" class="nav-link">{{ type.name }}</a>
          </li>
        </ul>
      </div>
    </div>
    <div class="col-xs col-lg-8 order-menu">
      <h2>Menu</h2>
      <div v-for="type in types" :key="type.key">
        <!-- <h3 class="my-3">{{ type.name }}</h3> -->
        <div class="card mb-3">
          <div class="card-header bg-white" :id="type.key">
            <h3>
              {{ type.name }} <small v-if="type.key === 'starter'" class="text-muted">(4 pièces)</small>
            </h3>
          </div>
          <div>
            <ul class="list-group list-group-flush">
              <li v-for="product in products" v-if="product.type === type.key" class="list-group-item bg-light" :key="product.id">
                <OrderMenuItem
                  v-if="product.type === 'main'"
                  :id="product.id"
                  :name="product.name"
                  :price="Number(product.price)"
                  :description="product.description"
                  :options="mainOptions"
                  :ref="`expandable${product.id}`"
                  @add="add"
                  @expand="handleExpand(product.id)"
                />
                <OrderMenuItem v-else :id="product.id" :name="product.name" :price="Number(product.price)" :description="product.description" @add="add"/>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import VueSticky from 'vue-sticky'
import OrderMenuItem from './OrderMenuItem'
const VueScrollTo = require('vue-scrollto') // eslint-disable-line no-unused-vars

export default {
  components: {
    OrderMenuItem
  },

  directives: {
    'sticky': VueSticky
  },

  props: {
    products: {
      type: Array,
      required: true
    },
    handleAdd: {
      type: Function,
      required: true
    }
  },

  data() {
    return {
      types: [{
        key: 'starter',
        name: 'Entrées'
      }, {
        key: 'main',
        name: 'Plats'
      }, {
        key: 'drink',
        name: 'Boissons'
      }],
      expandedProductId: null,
      optionId: 0
    }
  },

  computed: {
    mainOptions () {
      return [{
        name: 'Sauce',
        products: this.products.filter(product => product.type === 'side')
      }]
    }
  },

  methods: {
    handleExpand(productId ) {
      this.expandedProductId = this.expandedProductId === productId ? null : productId
      if (this.$refs) {
        for (let key in this.$refs) {
          if (this.$refs[key][0] != this.$refs[`expandable${productId}`][0]) {
            this.$refs[key][0].expandLess()
          }
        }
      }
    },
    add (productId) {
      this.handleAdd(this.products.find(product => product.id === productId))
      if (this.$refs[`expandable${productId}`]) {
        this.$refs[`expandable${productId}`][0].expandLess()
      }
    },
    handleAddWithOption(product, optionId) {
      this.expandedProductId = null
      this.handleAdd(product, this.products.find(product => product.id === optionId))
    },
    scrollToTag: function(tag) {
      const options = {
        container: 'body',
        easing: 'ease-in',
        offset: -100,
        cancelable: true,
        onDone: function() {
          // scrolling is done
        },
        onCancel: function() {
          // scrolling has been interrupted
        },
        x: false,
        y: true
      }
      this.$scrollTo(`#${tag}`, 500, options)
    }
  }
}
</script>


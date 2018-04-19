<template>
  <div class="row mb-5">
    <div class="d-none d-lg-block col-lg-4 order-nav">
      <div v-sticky="{ zIndex: 1020, stickyTop: 115 }">
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
                <div class="d-flex flex-row align-items-center">
                  {{ product.name }}
                  <span class="ml-auto">{{ product.price.toString().replace('.', ',') }} €</span>
                  <button v-if="type.key === 'main'" class="btn btn-sm btn-outline-primary ml-2" @click="handleExpand(product)">
                    <div class="d-flex align-items-center text-primary">
                      <i v-if="product.id !== expandedProductId" class="material-icons">expand_more</i>
                      <i v-else class="material-icons">expand_less</i>
                    </div>
                  </button>
                  <button v-else class="btn btn-sm btn-outline-primary ml-2" @click="handleAdd(product)">
                    <div class="d-flex align-items-center text-primary">
                      <i class="material-icons">add</i>
                    </div>
                  </button>
                </div>
                <div v-if="product.id === expandedProductId">
                  <p class="mt-3 mb-0">
                    Tous nos plats sont accompagnés de riz blanc et de lentilles. Une sauce pimentée (rougail) est également offerte.
                  </p>
                  <div class="input-group my-3">
                    <div class="input-group-prepend">
                      <label class="input-group-text" :for="'select-side-' + product.id">Sauce</label>
                    </div>
                    <select v-model="optionId" class="custom-select" :id="'select-side-' + product.id">
                      <option selected value="0">Aucun</option>
                      <option v-for="side in products.filter(product => product.type === 'side')" :value="side.id" :key="side.id">
                        {{ side.name }}
                      </option>
                    </select>
                  </div>
                  <button class="btn btn-block btn-primary" @click="handleAddWithOption(product, optionId)">
                    Ajouter
                  </button>
                </div>
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
const VueScrollTo = require('vue-scrollto') // eslint-disable-line no-unused-vars

export default {
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
  methods: {
    handleExpand(product) {
      this.expandedProductId = this.expandedProductId === product.id ? null : product.id
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


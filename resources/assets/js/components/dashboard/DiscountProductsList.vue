<template>
  <div>
    <!-- Discount products -->
    <div v-for="type in types" v-if="shouldDisplay(type.type)" class="card mb-3">
      <div class="card-header">{{ type.title }}</div>
      <ul class="list-group list-group-flush">
        <li v-for="(product, i) in discountProducts.filter(p => p.type === type.type)" class="list-group-item">
          <div class="form-inline d-flex">
            <div class="mr-auto">
              {{ product.name }}
              <button type="button" class="btn btn-sm btn-outline-danger ml-3" @click="removeProduct(product.id)">Supprimer</button>
            </div>
            <input hidden type="number" :name="`products[${i}][id]`" :value="product.id">
            <div class="form-group">
              <label :for="`percent-${i}`">Pourcentage</label>
              <input :id="`percent-${i}`" :name="`products[${i}][percent]`" type="number" class="form-control ml-3" min="0" max="100">
            </div>
            <div class="form-group ml-3">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" :name="`products[${i}][required]`" :id="`required-${i}`" value="1" checked>
                <label class="form-check-label" :for="`required-${i}`">Requis</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" :name="`products[${i}][required]`" :id="`not-required-${i}`" value="0">
                <label class="form-check-label" :for="`not-required-${i}`">Non requis</label>
              </div>
            </div>
          </div>
        </li>
      </ul>
    </div>
    <!-- Add product section -->
    <div class="input-group">
      <select v-model="productId" class="custom-select">
        <option :value="null">Ajouter un produit</option>
        <optgroup v-for="type in types" :label="type.title">
          <option v-for="product in products.filter(p => p.type === type.type)" :value="product.id">
            {{ product.name }} <span v-if="product.disabled" class="text-muted">- Désactivé</span>
          </option>
        </optgroup>
      </select>
      <div class="input-group-append">
        <button class="btn btn-default" type="button" @click="addProduct">Ajouter</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    types: {
      type: Array,
      required: true
    },
    products: {
      type: Array,
      required: true
    },
    initialDiscountProducts: {
      type: Array,
      default: () => []
    }
  },

  data () {
    return {
      productId: null,
      discountProducts: []
    }
  },

  mounted () {
    if (this.initialDiscountProducts) {
      this.discountProducts = this.initialDiscountProducts
      // it's easier to manipulate products if they have name and type
      this.discountProducts.forEach(product => {
        const ref = this.products.find(p => p.id === Number(product.id))
        product.name = ref.name
        product.type = ref.type
      })
    }
  },

  methods: {
    addProduct () {
      if (this.productId && !this.discountProducts.find(p => p.id === this.productId)) {
        const ref = this.products.find(p => p.id === this.productId)
        this.discountProducts.push({
          id: this.productId,
          name: ref.name,
          type: ref.type,
          percent: 100,
          required: true
        })
      }
    },
    removeProduct (productId) {
      this.discountProducts = this.discountProducts.filter(product => product.id !== productId)
    },
    shouldDisplay (type) {
      return this.discountProducts.filter(product => product.type === type).length
    }
  }
}
</script>

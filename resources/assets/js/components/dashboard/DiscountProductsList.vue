<template>
  <div>
    <!-- Discount products -->
    <div v-for="(type, index) in types" v-if="shouldDisplay(type.type)" :key="index" class="card mb-3">
      <div class="card-header">{{ type.title }}</div>
      <ul class="list-group list-group-flush">
        <li v-for="(product, i) in discountProducts.filter(p => p.type === type.type)" :key="i" class="list-group-item">
          <div class="form-inline d-flex">
            <div class="mr-auto">
              {{ product.name }}
              <button type="button" class="btn btn-sm btn-outline-danger ml-3" @click="removeProduct(product.id)">Supprimer</button>
            </div>
            <input :name="`products[${i}][id]`" :value="product.id" hidden type="number">
            <div class="form-group">
              <label :for="`percent-${i}`">Pourcentage</label>
              <input :id="`percent-${i}`" :name="`products[${i}][percent]`" :value="product.pivot ? product.pivot.percent : 100" type="number" class="form-control ml-3" min="0" max="100">
            </div>
            <div class="form-group ml-3">
              <label :for="`max_items-${i}`">Nombre max.</label>
              <input :id="`max_items-${i}`" :name="`products[${i}][max_items]`" :value="product.pivot ? product.pivot.max_items : 1" type="number" class="form-control ml-3" min="1" max="100">
            </div>
            <div class="form-group ml-3">
              <div class="form-check form-check-inline">
                <input :id="`required-${i}`" :name="`products[${i}][required]`" :checked="product.pivot ? product.pivot.required : true" class="form-check-input" type="radio" value="1">
                <label :for="`required-${i}`" class="form-check-label">Requis</label>
              </div>
              <div class="form-check form-check-inline">
                <input :id="`not-required-${i}`" :name="`products[${i}][required]`" :checked="product.pivot ? !product.pivot.required : false" class="form-check-input" type="radio" value="0">
                <label :for="`not-required-${i}`" class="form-check-label">Non requis</label>
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
        <optgroup v-for="(type, i) in types" :label="type.title" :key="i">
          <option v-for="product in products.filter(p => p.type === type.type)" :value="product.id" :key="product.id">
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

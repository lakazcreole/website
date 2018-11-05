<template>
  <div>
    <div v-show="itemProducts.length" class="mb-2">Applicable sur un élément parmi :</div>
    <!-- Discount products -->
    <div v-for="type in productTypes" v-if="shouldDisplay(type.type)" :key="type.type">
      <div class="font-weight-bold mb-2">{{ type.title }}</div>
      <ul>
        <li v-for="(product, i) in itemProducts.filter(p => p.type === type.type)" :key="i">

          <input :value="product.id" :name="`items[${index}][products][]`" type="hidden">
          {{ product.name }}
          <button type="button" class="btn btn-sm btn-outline-danger ml-2" @click="removeProduct(product.id)">Supprimer</button>
        </li>
      </ul>
    </div>
    <!-- Add product section -->
    <div class="input-group">
      <select v-model="productId" class="custom-select">
        <option :value="null">Ajouter un produit</option>
        <optgroup v-for="(type, i) in productTypes" :label="type.title" :key="i">
          <option v-for="product in products.filter(p => p.type === type.type)" :value="product.id" :key="product.id">
            {{ product.name }} <span v-if="product.disabled" class="text-muted">- Désactivé</span>
          </option>
        </optgroup>
      </select>
      <div class="input-group-append">
        <button class="btn btn-primary" type="button" @click="addProduct">Ajouter</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    productTypes: {
      type: Array,
      required: true
    },
    products: {
      type: Array,
      required: true
    },
    index: { // index in items array
      type: Number,
      required: true
    },
    initialItemProducts: { // array of product ids
      type: Array,
      default: () => []
    }
  },

  data () {
    return {
      productId: null,
      itemProducts: []
    }
  },

  mounted () {
    if (this.initialItemProducts && this.initialItemProducts.length) {
      console.log(this.initialItemProducts)
      // it's easier to manipulate products if they have name and type
      this.initialItemProducts.forEach(productId => {
        const ref = this.products.find(p => p.id === Number(productId))
        this.itemProducts.push({
          id: ref.id,
          name: ref.name,
          type: ref.type
        })
      })
    }
  },

  methods: {
    addProduct () {
      if (this.productId && !this.itemProducts.find(p => p.id === this.productId)) {
        const ref = this.products.find(p => p.id === this.productId)
        this.itemProducts.push({
          id: ref.id,
          name: ref.name,
          type: ref.type
        })
      }
      this.$emit('add', this.productId)
    },
    removeProduct (productId) {
      this.itemProducts = this.itemProducts.filter(product => product.id !== productId)
      this.$emit('remove', this.productId)
    },
    shouldDisplay (type) {
      return this.itemProducts.filter(product => product.type === type).length
    }
  }
}
</script>

<template>
  <div>
    <div class="d-flex mb-2">
      Objets de la réduction
      <div class="ml-auto">
        <button type="button" class="btn btn-sm btn-primary" @click="addItem">Ajouter</button>
      </div>
    </div>
    <div v-for="(item, index) in items" :key="index" class="card mb-3">
      <input v-if="item.id" :value="item.id" :name="`items[${index}][id]`" type="hidden">
      <div class="card-header d-flex">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group mb-0">
              <label :for="`percent-${index}`" class="sr-only">Pourcentage</label>
              <div class="input-group">
                <input v-model="item.percent" :id="`percent-${index}`" :name="`items[${index}][percent]`" type="number" class="form-control">
                <div class="input-group-append">
                  <span class="input-group-text">% de réduction</span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6 d-flex">
            <div class="form-group mb-0 my-auto">
              <div class="form-check form-check-inline">
                <input v-model="item.required" :id="`required-${index}`" :name="`items[${index}][required]`" :checked="item.required" class="form-check-input" type="radio" value="1">
                <label :for="`required-${index}`" class="form-check-label">Requis</label>
              </div>
              <div class="form-check form-check-inline">
                <input v-model="item.required" :id="`not-required-${index}`" :name="`items[${index}][required]`" :checked="!item.required" class="form-check-input" type="radio" value="0">
                <label :for="`not-required-${index}`" class="form-check-label">Non requis</label>
              </div>
            </div>
          </div>
        </div>
        <div class="ml-auto my-auto">
          <button type="button" class="btn btn-sm btn-outline-secondary" @click="duplicateItem(item)">Dupliquer</button>
          <button type="button" class="btn btn-sm btn-outline-danger ml-1" @click="removeItem(index)">Supprimer</button>
        </div>
      </div>
      <div class="card-body">
        <DiscountItemProductsInput
          :product-types="productTypes"
          :products="products"
          :index="index"
          :initial-item-products="item.products | onlyIds"
          @add="id => addProduct(item, id)"
          @remove="id => removeProduct(item, id)"
        />
      </div>
    </div>
  </div>
</template>

<script>
import DiscountItemProductsInput from './DiscountItemProductsInput'

export default {
  components: {
    DiscountItemProductsInput
  },
  filters: {
    onlyIds (products) {
      return products.map(item => {
        if (typeof item === 'object') return item.id
        return Number(item)
      })
    }
  },
  props: {
    productTypes: {
      type: Array,
      required: true
    },
    products: {
      type: Array,
      required: true
    },
    initialItems: {
      type: Array,
      default: () => []
    }
  },
  data () {
    return {
      items: []
    }
  },
  mounted () {
    if (this.initialItems && this.initialItems.length) {
      this.items = this.initialItems
    } else {
      this.items.push({
        percent: 100,
        required: 1,
        products: []
      })
    }
  },
  methods: {
    addItem () {
      this.items.push({
        percent: 100,
        required: 1,
        products: []
      })
    },
    duplicateItem (item) {
      this.items.push({
        percent: item.percent,
        required: item.required,
        products: item.products
      })
    },
    removeItem (index) {
      this.items.splice(index, 1)
    },
    addProduct (item, id) {
      item.products.push(id)
    },
    removeProduct (item, id) {
      item.products = item.products.filter(i => i === id)
    }
  }
}
</script>

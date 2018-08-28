import { shallowMount, createLocalVue } from '@vue/test-utils'
import Vuex from 'vuex'
import expect from 'expect'

import ProductsList from '../../../resources/js/components/shop/ProductsList.vue'
import ProductsListItem from '../../../resources/js/components/shop/ProductsListItem.vue'
import store from '../../../resources/js/store'

const localVue = createLocalVue()
localVue.use(Vuex)


const factory = (props = {}) => {
  return shallowMount(ProductsList, {
    mocks: {
      $store: store
    },
    localVue,
    propsData: {
      products: [],
      ...props
    }
  })
}

const productsFactory = () => {
  return [{
    id: 1,
    name: 'Test',
    price: 2,
    type: 'starter'
  }, {
    id: 2,
    name: 'Product',
    price: 3,
    type: 'desert'
  }]
}

const productTypesFactory = () => {
  return [{
    key: 'starter',
    name: 'Entrées'
  }, {
    key: 'main',
    name: 'Plats'
  }, {
    key: 'desert',
    name: 'Desserts'
  },
  {
    key: 'drink',
    name: 'Boissons'
  }]
}

describe('ProductsList', () => {

  it('displays categories only if they are not empty', () => {
    const wrapper = factory()
    wrapper.vm.$store.state.products.all = productsFactory()
    wrapper.vm.$store.state.products.types = productTypesFactory()
    expect(wrapper.text()).not.toContain('Plats')
    expect(wrapper.text()).not.toContain('Boissons')
    expect(wrapper.text()).toContain('Entrées')
    expect(wrapper.text()).toContain('Desserts')
  })

  it('displays as many ProductsListItem as there are products', () => {
    const wrapper = factory()
    wrapper.vm.$store.state.products.all = productsFactory()
    wrapper.vm.$store.state.products.types = productTypesFactory()
    expect(wrapper.findAll(ProductsListItem).length).toBe(2)
  })

  it('updates the store when child components emit an add event', () => {
    const wrapper = factory()
    wrapper.vm.$store.state.products.all = productsFactory()
    wrapper.vm.$store.state.products.types = productTypesFactory()
    wrapper.vm.$store.state.cart.items = []
    const childWrapper = wrapper.find(ProductsListItem)
    childWrapper.vm.$emit('add', childWrapper.props().id)
    expect(wrapper.vm.$store.state.cart.items.find(i => i.id === childWrapper.props().id)).not.toBe(undefined)
  })
})

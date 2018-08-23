import { shallowMount, mount, createLocalVue } from '@vue/test-utils'
import expect from 'expect'
import Vuex from 'vuex'

import Cart from '../../../resources/js/components/shop/Cart.vue'
import CartItem from '../../../resources/js/components/shop/CartItem.vue'
import Alert from '../../../resources/js/components/Alert.vue'
import store from '../../../resources/js/store'

const localVue = createLocalVue()
localVue.use(Vuex)

const factory = (props = {}) => {
  return shallowMount(Cart, {
    mocks: {
      $store: store
    },
    localVue,
    propsData: {
      editable: true,
      ...props
    }
  })
}

const itemsFactory = () => {
  return [{
    id: 1,
    quantity: 1,
  }, {
    id: 2,
    quantity: 2,
  }]
}

const productsFactory = () => {
  return [{
      id: 1,
      name: 'Some product',
      price: 2,
      description: null
  }, {
      id: 2,
      name: 'Other product ',
      price: 3,
      description: 'Better product'
  }]
}

describe('Cart', () => {

  it('initially displays a price of 0 €', () => {
    const wrapper = factory()
    wrapper.vm.$store.state.cart.items = []
    expect(wrapper.text()).toContain('Total 0,00 €')
  })

  it('displays all the items in the cart', () => {
    const wrapper = factory()
    const items = itemsFactory()
    wrapper.vm.$store.state.products.all = productsFactory()
    wrapper.vm.$store.state.cart.items = items
    expect(wrapper.findAll(CartItem).length).toBe(items.length)
  })

  it('displays the full price', () => {
    const wrapper = factory()
    wrapper.vm.$store.state.products.all = productsFactory()
    wrapper.vm.$store.state.cart.items = itemsFactory()
    expect(wrapper.text()).toContain('Total 10,00 €')
  })

  it('displays a delivery cost if not empty and total price below 15', () => {
    const wrapper = factory()
    wrapper.vm.$store.state.products.all = productsFactory()
    wrapper.vm.$store.state.cart.items = [{ id: 1, quantity: 1 }]
    expect(wrapper.find('.delivery').text()).toContain('Offert à partir de 15 € de commande (hors frais).')
  })

  it('does not display a delivery cost when total price above 15', () => {
    const wrapper = factory()
    wrapper.vm.$store.state.products.all = productsFactory()
    wrapper.vm.$store.state.cart.items = [{ id: 1, quantity: 15}]
    expect(wrapper.find('.delivery').text()).not.toContain('Offert à partir de 15 € de commande (hors frais).')
    expect(wrapper.find('.delivery').text()).toContain('Frais de livraison Offert')
  })

  it('adjust the delivery cost for total prices between 13 and 15', () => {
    const wrapper = factory()
    wrapper.vm.$store.state.products.all = [{ id: 1, name: 'Product', price: 14 }]
    wrapper.vm.$store.state.cart.items = [{ id: 1, quantity: 1 }]
    expect(wrapper.find('.delivery').text()).toContain('1,00 €')
  })

  it('displays a message when full price is below 8', () => {
    const wrapper = factory()
    wrapper.vm.$store.state.products.all = productsFactory()
    wrapper.vm.$store.state.cart.items = [{ id: 1, quantity: 1 }]
    const alertWrapper = wrapper.find(Alert)
    expect(alertWrapper.props().color).toBe('red')
    expect(alertWrapper.isVisible()).toBe(true)
  })

  it('does not display a message when full price is above 8', () => {
    const wrapper = factory()
    wrapper.vm.$store.state.products.all = [{ id: 1, name: 'Thing', price: 6 }]
    wrapper.vm.$store.state.cart.items = [{ id: 1, quantity: 1 }]
    const alertWrapper = wrapper.find(Alert)
    expect(alertWrapper.props().color).toBe('red')
    expect(wrapper.find(Alert).isVisible()).toBe(false)
  })

  it('removes the item from the cart when CartItem emits a remove event', () => {
    const wrapper = factory()
    const productId = 1
    wrapper.vm.$store.state.products.all = [{ id: productId, name: 'Thing', price: 6 }]
    wrapper.vm.$store.state.cart.items = [{ id: productId, quantity: 1 }]
    const childWrapper = wrapper.find(CartItem)
    childWrapper.vm.$emit('remove', productId)
    expect(wrapper.vm.items.find(item => item.id === productId)).toBe(undefined)
  })

})

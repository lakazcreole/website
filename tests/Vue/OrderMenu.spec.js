import { shallowMount } from '@vue/test-utils'
import OrderMenu from '../../resources/assets/js/components/OrderMenu.vue'
import OrderMenuItem from '../../resources/assets/js/components/OrderMenuItem.vue'
import expect from 'expect'

const factory = (props = {}) => {
  return shallowMount(OrderMenu, {
    propsData: {
      products: [],
      ...props
    }
  })
}

const itemsFactory = () => {
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

describe('OrderMenu', () => {

  it('displays categories only if they are not empty', () => {
    const wrapper = factory({
      products: itemsFactory()
    })
    expect(wrapper.text()).not.toContain('Plats')
    expect(wrapper.text()).not.toContain('Boissons')
    expect(wrapper.text()).toContain('Entrées')
    expect(wrapper.text()).toContain('Desserts')
  })

  it('displays as many OrderMenuItem as there are products', () => {
    const wrapper = factory({
      products: itemsFactory()
    })
    expect(wrapper.findAll(OrderMenuItem).length).toBe(2)
  })

  it('emits an add event when child components emit an add event', () => {
    const wrapper = factory({
      products: itemsFactory()
    })
    const childWrapper = wrapper.find(OrderMenuItem)
    childWrapper.vm.$emit('add', childWrapper.id)
    expect(wrapper.emitted('add')[0]).toEqual([childWrapper.id])
  })
})

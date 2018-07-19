import { shallowMount } from '@vue/test-utils'
import expect from 'expect'

import OrderOffer from '../../resources/assets/js/components/OrderOffer'
import OrderOffersMenu from '../../resources/assets/js/components/OrderOffersMenu'

const offersFactory = () => {
  return [{
    product: {
      id: 1,
      name: 'Some offer',
      price: 2,
      imageUrl: '/some/path.jpg',
      description: null
    }
  }, {
    product: {
      id: 2,
      name: 'Other offer ',
      price: 3,
      imageUrl: '/other/path.jpg',
      description: 'Better offer'
    }
  }]
}

const factory = (props = {}) => {
  return shallowMount(OrderOffersMenu, {
    propsData: {
      ...props
    }
  })
}

describe('OrderOffersMenu', () => {

  it('displays all the products', () => {
    const wrapper = factory({
      offers: offersFactory()
    })
    expect(wrapper.findAll(OrderOffer).length).toBe(2)
  })

  it('fires an add event when OrderOffer fires an add event', () => {
    const wrapper = factory({
      offers: offersFactory()
    })
    const childWrapper = wrapper.find(OrderOffer)
    childWrapper.vm.$emit('add')
    expect(wrapper.emitted('addProduct')[0]).toEqual([{ // this will be refactored when OrderManager is refactored
      id: 1,
      name: 'Some offer',
      price: 2,
      imageUrl: '/some/path.jpg',
      description: null
    }])
  })

})

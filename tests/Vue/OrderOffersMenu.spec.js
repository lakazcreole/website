import { shallow } from '@vue/test-utils'
import expect from 'expect'

import OrderOffer from '../../resources/assets/js/components/OrderOffer'
import OrderOffersMenu from '../../resources/assets/js/components/OrderOffersMenu'

const productsFactory = () => {
  return [{
    id: 1,
    name: 'Some offer',
    price: 2,
    imageUrl: '/some/path.jpg',
    description: null
  }, {
    id: 2,
    name: 'Other offer ',
    price: 3,
    imageUrl: '/other/path.jpg',
    description: 'Better offer'
  }]
}

const factory = (props = {}) => {
  return shallow(OrderOffersMenu, {
    propsData: {
      ...props
    }
  })
}

describe('OrderOffersMenu', () => {

  it('displays all the products', () => {
    const wrapper = factory({
      products: productsFactory()
    })
    expect(wrapper.findAll(OrderOffer).length).toBe(2)
  })

  it('fires an add event when OrderOffer fires an add event', () => {
    const wrapper = factory({
      products: productsFactory()
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

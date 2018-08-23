import { shallowMount } from '@vue/test-utils'
import CartItem from '../../../resources/js/components/shop/CartItem.vue'
import expect from 'expect'

const factory = (props = {}) => {
  return shallowMount(CartItem, {
    propsData: {
      id: 1,
      name: 'Product',
      price: 1,
      quantity: 1,
      ...props
    }
  })
}

describe('CartItem', () => {

  it('displays the item\'s name', () => {
    const wrapper = factory({ name: 'This Product'})
    expect(wrapper.text()).toContain('This Product')
  })

  it('displays the quantity of item(s)', () => {
    const wrapper = factory({ quantity: 24 })
    expect(wrapper.find('.quantity').text()).toContain('24')
  })

  it('displays the correct price in French', () => {
    const wrapper = factory({quantity: 5, price: 3 })
    expect(wrapper.find('.price').text()).toContain('15,00 €')
  })

  it('has a remove button when editable', () => {
    const wrapper = factory({ editable: true })
    expect(wrapper.find('button').isVisible()).toBe(true)
  })

  it('has no remove button by default', () => {
    const wrapper = factory()
    expect(wrapper.find('button').isVisible()).toBe(false)
  })

  it('fires a remove event when remove button is clicked', () => {
    const wrapper = factory({ editable: true })
    wrapper.find('button').trigger('click')
    expect(wrapper.emitted('remove')[0]).toEqual([wrapper.props().id])
  })

})

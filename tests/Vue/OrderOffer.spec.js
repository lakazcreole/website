import { shallowMount } from '@vue/test-utils'
import expect from 'expect'

import OrderOffer from '../../resources/assets/js/components/OrderOffer.vue'

const factory = (props = {}) => {
  return shallowMount(OrderOffer, {
    propsData: {
      id: 0,
      name: 'Product',
      price: 15,
      imgSrc: '',
      description: null,
      ...props
    }
  })
}

describe('OrderOffer', () => {

  it('displays the name', () => {
    const wrapper = factory({ name: 'Something weird but delicious'})
    expect(wrapper.text()).toContain('Something weird but delicious')
  })

  it('displays the price in French', () => {
    const wrapper = factory({ price: 15 })
    expect(wrapper.find('.price').text()).toContain('15,00 €')
  })

  it('shows a tooltip if it has a description', () => {
    const wrapper = factory({ description: 'Some things' })
    expect(wrapper.find('.info').exists()).toBe(true)
  })

  it('does not shows a tooltip if it has no description', () => {
    const wrapper = factory({ description: '' })
    expect(wrapper.find('.info').exists()).toBe(false)
  })

  it('displays the image', () => {
    const wrapper = factory({ name: 'Something to eat', imgSrc: '/some/path.jpg'})
    expect(wrapper.find('img').attributes().src).toBe('/some/path.jpg')
    expect(wrapper.find('img').attributes().alt).toBe('Something to eat')
  })

  it('has a add button', () => {
    const wrapper = factory({})
    expect(wrapper.find('button').text()).toContain('Ajouter')
  })

  it('emits a add event when the button is clicked', () => {
    const wrapper = factory({ id: 68 })
    wrapper.find('button').trigger('click')
    expect(wrapper.emitted().add).toBeTruthy
  })

})

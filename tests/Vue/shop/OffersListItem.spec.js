import { shallowMount } from '@vue/test-utils'
import expect from 'expect'

import OffersListItem from '../../../resources/assets/js/components/shop/OffersListItem'
import InformationTooltip from '../../../resources/assets/js/components/InformationTooltip'

const factory = (props = {}) => {
  return shallowMount(OffersListItem, {
    propsData: {
      productId: 1,
      productName: 'Product',
      productPrice: 15,
      productDescription: null,
      imgSrc: '',
      ...props
    }
  })
}

describe('OffersListItem', () => {

  it('displays the name', () => {
    const productName = 'Something weird but delicious'
    const wrapper = factory({ productName: productName})
    expect(wrapper.text()).toContain(productName)
  })

  it('displays the price in French', () => {
    const wrapper = factory({ productPrice: 15 })
    expect(wrapper.text()).toContain('15,00 €')
  })

  it('shows a information tooltip if product has a description', () => {
    const wrapper = factory({ productDescription: 'Some things' })
    expect(wrapper.find(InformationTooltip).exists()).toBe(true)
  })

  it('does not shows a tooltip if it has no description', () => {
    const wrapper = factory({ productDescription: '' })
    expect(wrapper.find(InformationTooltip).exists()).toBe(false)
  })

  it('displays the image', () => {
    const wrapper = factory({ productName: 'Something to eat', imgSrc: '/some/path.jpg'})
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

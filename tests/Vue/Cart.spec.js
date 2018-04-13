import { shallow } from '@vue/test-utils'
import Cart from '../../resources/assets/js/components/NewCart.vue'
import expect from 'expect'

const factory = (props = {}) => {
  return shallow(Cart, {
    propsData: {
      items: [],
      ...props
    }
  })
}

describe('Cart', () => {

  it('initially displays a price of 0 €', () => {
    const wrapper = factory()
    expect(wrapper.find('.total').text()).toContain('Total : 0,00 €')
  })

  it('displays all the items in the cart', () => {
    const wrapper = factory({
      items: [{
        name: 'Cat',
        quantity: 1,
      }, {
        name: 'Dog',
        quantity: 2,
      }]
    })
    const items = wrapper.findAll('ul > li')
    expect(items.at(0).text()).toContain('1 Cat')
    expect(items.at(1).text()).toContain('2 Dog')
  })

  it('displays the full price', () => {
    const wrapper = factory({
      items: [{
        quantity: 1,
        price: 4
      }, {
        quantity: 2,
        price: 3
      }]
    })
    expect(wrapper.find('.total').text()).toContain('Total : 12,00 €')
  })

  it('removing an item fires an remove event', () => {
    const item = { id: 1 }
    const wrapper = factory({
      items: [item]
    })
    wrapper.find('ul > li .remove').trigger('click')
    expect(wrapper.emitted('remove')[0]).toEqual([item])
  })

  it('displays a delivery cost when total price below 15', () => {
    const wrapper = factory()
    expect(wrapper.find('ul > li.delivery').text()).toContain('Offert à partir de 15 € de commande (hors frais).')
  })

  it('does not display a delivery cost when total price above 15', () => {
    const wrapper = factory({
      items: [{
        quantity: 1,
        price: 15
      }]
    })
    expect(wrapper.find('ul').text()).not.toContain('Offert à partir de 15 € de commande (hors frais).')
    expect(wrapper.find('ul > li.delivery').text()).toContain('Livraison Offert')
  })

  it('adjust the delivery cost for total prices between 13 and 15', () => {
    const wrapper = factory({
      items: [{
        quantity: 1,
        price: 14
      }]
    })
    expect(wrapper.find('ul > li.delivery').text()).toContain('1,00 €')
  })

  it('displays a message when total price is below 8', () => {
    const wrapper = factory({
      items: [{
        quantity: 1,
        price: 7.99
      }]
    })
    expect(wrapper.find('ul > li:last-child').text()).toContain('Minimum de commande (8 €) non atteint.')
  })

  it('has an edit button that fires and edit event', () => {
    const wrapper = factory()
    wrapper.find('button.edit').trigger('click')
    expect(wrapper.emitted('edit')).toBeTruthy()
  })

  it('has a validate button that fires a validate event', () => {
    const wrapper = factory({
      items: [{
        quantity: 1,
        price: 14
      }]
    })
    wrapper.find('button.validate').trigger('click')
    expect(wrapper.emitted('validate')).toBeTruthy()
  })

})

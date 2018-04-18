import { shallow, mount } from '@vue/test-utils'
import Cart from '../../resources/assets/js/components/Cart.vue'
import CartItem from '../../resources/assets/js/components/CartItem.vue'
import expect from 'expect'

const factory = (props = {}) => {
  return shallow(Cart, {
    propsData: {
      editable: true,
      items: [],
      ...props
    }
  })
}

const itemsFactory = () => {
  return [{
    id: 1,
    name: 'Test',
    quantity: 1,
    price: 2
  }, {
    id: 2,
    name: 'Product',
    quantity: 2,
    price: 3
  }]
}

describe('Cart', () => {

  it('initially displays a price of 0 €', () => {
    const wrapper = factory()
    expect(wrapper.find('.total').text()).toContain('Total : 0,00 €')
  })

  it('displays all the items in the cart', () => {
    const wrapper = factory({
      items: itemsFactory().concat(itemsFactory())
    })
    expect(wrapper.findAll(CartItem).length).toBe(4)
  })

  it('displays the full price', () => {
    const wrapper = factory({
      items: itemsFactory()
    })
    expect(wrapper.find('.total').text()).toContain('Total : 10,00 €')
  })

  it('fires a removeItem event when CartItem fires a remove event', () => {
    const wrapper = factory({
      items: itemsFactory()
    })
    const childWrapper = wrapper.find(CartItem)
    childWrapper.vm.$emit('remove', childWrapper.id)
    expect(wrapper.emitted('removeItem')[0]).toEqual([childWrapper.id])
  })

  it('has remove buttons when editable', () => {
    const wrapper = mount(Cart, {
      propsData: {
        editable: true,
        items: itemsFactory()
      }
    })
    expect(wrapper.findAll(CartItem).contains('button.remove')).toBe(true)
  })

  it('displays a delivery cost if not empty and total price below 15', () => {
    const wrapper = factory({
      items: itemsFactory()
    })
    expect(wrapper.find('ul > li.delivery').text()).toContain('Offert à partir de 15 € de commande (hors frais).')
  })

  it('does not display a delivery cost when total price above 15', () => {
    const wrapper = factory({
      items: [{
        id: 1,
        name: 'Product',
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
        id: 1,
        name: 'Product',
        quantity: 1,
        price: 14
      }]
    })
    expect(wrapper.find('ul > li.delivery').text()).toContain('1,00 €')
  })

  it('displays a message when total price is below 8', () => {
    const wrapper = factory({
      items: [{
        id: 1,
        name: 'Product',
        quantity: 1,
        price: 5.99
      }]
    })
    expect(wrapper.find('ul > li:last-child').text()).toContain('Minimum de commande (8 €) non atteint.')
  })

  it('has no edit button when editable', () => {
    const wrapper = factory()
    expect(wrapper.find('button.edit').exists()).toBe(false)
  })

  it('fires an edit event when clicking on edit button', () => {
    const wrapper = factory({
      editable: false
    })
    wrapper.find('button.edit').trigger('click')
    expect(wrapper.emitted('edit')).toBeTruthy()
  })

  it('has no validate button when not editable', () => {
    const wrapper = factory({
      editable: false
    })
    expect(wrapper.find('button.validate').exists()).toBe(false)
  })

  it('has a validate button that fires a validate event', () => {
    const wrapper = factory({
      items: itemsFactory()
    })
    wrapper.find('button.validate').trigger('click')
    expect(wrapper.emitted('validate')).toBeTruthy()
  })

})

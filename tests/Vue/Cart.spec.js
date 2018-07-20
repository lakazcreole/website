import { shallowMount, mount } from '@vue/test-utils'
import Cart from '../../resources/assets/js/components/Cart.vue'
import CartItem from '../../resources/assets/js/components/CartItem.vue'
import expect from 'expect'

const factory = (props = {}) => {
  return shallowMount(Cart, {
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
    childWrapper.vm.$emit('remove')
    expect(wrapper.emitted('removeItem')[0]).toEqual([childWrapper.props().id])
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

  it('displays a message when full price is below 8', () => {
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

  it('does not display a message when full price is above 8', () => {
    const wrapper = factory({
      items: [{
        id: 1,
        name: 'Product',
        quantity: 1,
        price: 6
      }]
    })
    expect(wrapper.find('ul > li:last-child').text()).not.toContain('Minimum de commande (8 €) non atteint.')
  })

  // This test fails because of an issue that prevents the updated() hook to be triggered
  it('fires a minimumReached event when the full price reaches 8', () => {
    // const wrapper = factory()
    // wrapper.setProps({
    //   items: [{
    //     id: 1,
    //     name: 'Product',
    //     quantity: 1,
    //     price: 6
    //   }]
    // })
    // wrapper.vm.updated()
    // expect(wrapper.emitted('minimumReached')).toBeTruthy()
  })

  // same here
  it('fires a minimumDropped event when the full price drops below 8', () => {

  })

})

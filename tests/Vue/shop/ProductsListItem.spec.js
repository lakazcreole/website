import { shallowMount, createLocalVue } from '@vue/test-utils'
import Vuex from 'vuex'
import expect from 'expect'

import ProductsListItem from '../../../resources/assets/js/components/shop/ProductsListItem.vue'
import store from '../../../resources/assets/js/store'

const localVue = createLocalVue()
localVue.use(Vuex)

const factory = (props = {}) => {
  return shallowMount(ProductsListItem, {
    mocks: {
      $store: store
    },
    localVue,
    propsData: {
      id: 1,
      name: 'Something',
      price: 2.99,
      expand: false,
      ...props
    }
  })
}

describe('ProductsListItem', () => {

  it('displays the name', () => {
    const wrapper = factory({ name: 'Burger' })
    expect(wrapper.text()).toContain('Burger')
  })

  it('displays the price in French', () => {
    const wrapper = factory({ price: 1.99 })
    expect(wrapper.text()).toContain('1,99 €')
  })

  it('displays the description if it has one', () => {
    const wrapper = factory({ description: 'Some things' })
    expect(wrapper.text()).toContain('Some things')
  })

  it('has an add button', () => {
    const wrapper = factory()
    expect(wrapper.find('button').text()).toContain('add')
  })

  it('has an expand button when there is options', () => {
    const wrapper = factory({ options: [
      {
        name: 'Sauce',
        products: [{ id: 99, name: 'Ketchup' }, { id: 100, name: 'Mayo' }]
      }
    ]})
    expect(wrapper.find('button').text()).toContain('expand_more')
  })

  it('hides the expandable section by default', () => {
    const wrapper = factory({ options: [
      {
        name: 'Sauce',
        products: [{ id: 99, name: 'Ketchup' }, { id: 100, name: 'Mayo' }]
      }
    ]})
    expect(wrapper.find('.expandable').isVisible()).toBe(false)
  })

  it('shows the expandable section when expand is true', () => {
    const wrapper = factory({
      expand: true,
      options: [{
        name: 'Sauce',
        products: [{ id: 99, name: 'Ketchup' }, { id: 100, name: 'Mayo' }]
      }]
    })
    expect(wrapper.find('.expandable').isVisible()).toBe(true)
  })

  it('emits an expand event when the expand button is clicked', () => {
    const wrapper = factory({ options: [
      {
        name: 'Sauce',
        products: [{ id: 99, name: 'Ketchup' }, { id: 100, name: 'Mayo' }]
      }
    ]})
    wrapper.find('button.expand').trigger('click')
    expect(wrapper.emitted().expand).toBeTruthy
  })

  it('emits an add event when add button is clicked', () => {
    const wrapper = factory()
    wrapper.find('button.add').trigger('click')
    expect(wrapper.emitted('add')[0]).toEqual([wrapper.props().id])
  })

  it('renders a select per option when there are options', () => {
    const wrapper = factory({ options: [
      {
        name: 'Sauce',
        products: [{ id: 99, name: 'Ketchup' }, { id: 100, name: 'Mayo' }]
      },
      {
        name: 'Sauce 2',
        products: [{ id: 99, name: 'Ketchup' }, { id: 100, name: 'Mayo' }]
      }
    ]})
    expect(wrapper.findAll('select').length).toBe(2)
  })

  it('emits two add events when add button is clicked when there is options', () => {
    const wrapper = factory({
      id: 1,
      options: [
      {
        name: 'Sauce',
        products: [{ id: 99, name: 'Ketchup' }, { id: 100, name: 'Mayo' }]
      },
      {
        name: 'Sauce 2',
        products: [{ id: 99, name: 'Ketchup' }, { id: 100, name: 'Mayo' }]
      }
    ]})
    wrapper.setData({ optionsValue: [99, 100] })
    wrapper.find('button.add').trigger('click')
    expect(wrapper.emitted('add')[0]).toEqual([wrapper.props().id])
    expect(wrapper.emitted('add')[1]).toEqual([99])
    expect(wrapper.emitted('add')[2]).toEqual([100])
  })
})

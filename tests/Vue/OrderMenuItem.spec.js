import { shallow } from '@vue/test-utils'
import OrderMenuItem from '../../resources/assets/js/components/OrderMenuItem.vue'
import expect from 'expect'

const factory = (props = {}) => {
  return shallow(OrderMenuItem, {
    propsData: {
      id: 1,
      name: 'Something',
      price: 2.99,
      ...props
    }
  })
}

describe('OrderMenuItem', () => {

  it('displays the name', () => {
    const wrapper = factory({ name: 'Burger' })
    expect(wrapper.text()).toContain('Burger')
  })

  it('displays the price in French', () => {
    const wrapper = factory({ price: 1.99 })
    expect(wrapper.text()).toContain('1,99 €')
  })

  it('shows a tooltip if it has a description', () => {
    const wrapper = factory({ description: 'Some things' })
    expect(wrapper.find('.info').exists()).toBe(true)
  })

  it('does not shows a tooltip if it has no description', () => {
    const wrapper = factory({ description: '' })
    expect(wrapper.find('.info').exists()).toBe(false)
  })

  it('has an add button', () => {
    const wrapper = factory()
    expect(wrapper.find('button').text()).toContain('add')
  })

  it('has an expend button when there is options', () => {
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

  it('shows the expandable section when expand button is clicked', () => {
    const wrapper = factory({ options: [
      {
        name: 'Sauce',
        products: [{ id: 99, name: 'Ketchup' }, { id: 100, name: 'Mayo' }]
      }
    ]})
    wrapper.find('button.expand').trigger('click')
    expect(wrapper.find('.expandable').isVisible()).toBe(true)
    wrapper.find('button.expand').trigger('click')
    expect(wrapper.find('.expandable').isVisible()).toBe(false)
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
    expect(wrapper.emitted('add')[0]).toEqual([wrapper.vm.id])
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
    expect(wrapper.vm.optionValues).toEqual([0, 0])
  })

  it('emits two add event when add-both button is clicked', () => {
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
    wrapper.setData({ optionValues: [99, 100] })
    wrapper.find('button.add').trigger('click')
    expect(wrapper.emitted('add')[0]).toEqual([1])
    expect(wrapper.emitted('add')[1]).toEqual([99])
    expect(wrapper.emitted('add')[2]).toEqual([100])
  })
})

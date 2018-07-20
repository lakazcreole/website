import Vuex from 'vuex'
import { shallowMount, mount, createLocalVue } from '@vue/test-utils'
import expect from 'expect'

import OrderTimeInput from '../../resources/assets/js/components/OrderTimeInput'
import DatePicker from 'vuejs-datepicker'
import store from '../../resources/assets/js/store'

const localVue = createLocalVue()
localVue.use(Vuex)

const factory = (props = {}) => {
  return shallowMount(OrderTimeInput, {
    mocks: {
      $store: store
    },
    localVue,
    propsData: {
      ...props
    }
  })
}

describe('OrderTimeInput', () => {

  it('has a date picker component', () => {
    const wrapper = factory()
    expect(wrapper.find(DatePicker).exists()).toBe(true)
  })

  it('defaults to the store date value', () => {
    const wrapper = factory()
    expect(wrapper.find(DatePicker).props().value).toBe(wrapper.vm.$store.state.order.date)
  })

  it('mutates the store date when date picker emits an input event', () => {
    const date = new Date()
    const wrapper = factory()
    const childWrapper = wrapper.find(DatePicker)
    childWrapper.vm.$emit('input', date)
    expect(wrapper.vm.$store.state.order.date).toBe(date)
  })

  it('has a select for time delivery', () => {
    const wrapper = factory()
    expect(wrapper.find('select').exists()).toBe(true)
  })

  it('has a help text when store time is null', () => {
    const wrapper = factory()
    expect(wrapper.find('select option').text()).toBe('Choisir un horaire')
  })

  it('defaults to the store time value if is different from null', () => {
    const time = '12:15'
    const wrapper = factory()
    wrapper.vm.$store.state.order.time = time
    expect(wrapper.find('select option:selected').text()).toBe(time)
  })

  it('mutates the store time when select emits an input event', () => {
    const wrapper = factory()
    const optionsWrapper = wrapper.find('select').findAll('option')
    optionsWrapper.at(1).setSelected()
    expect(wrapper.vm.$store.state.order.time).toBe(optionsWrapper.at(1).element.value)
  })

  it('displays all delivery hours from the store state', () => {
    const wrapper = factory()
    const hours = {
      morning: ['08:59', '12:37'],
      evening: ['17:06', '23:01']
    }
    wrapper.vm.$store.state.order.deliveryHours = hours
    hours.morning.concat(hours.evening).forEach((hour) => {
      expect(wrapper.find('select').text()).toContain(hour)
    })
  })
})

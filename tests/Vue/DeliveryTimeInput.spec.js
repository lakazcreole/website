import Vuex from 'vuex'
import { shallow, mount, createLocalVue } from '@vue/test-utils'
import expect from 'expect'

import DeliveryTimeInput from '../../resources/assets/js/components/DeliveryTimeInput'
import DatePicker from 'vuejs-datepicker'
import store from '../../resources/assets/js/store'

const localVue = createLocalVue()
localVue.use(Vuex)

const factory = (props = {}) => {
  return shallow(DeliveryTimeInput, {
    mocks: {
      $store: store
    },
    localVue,
    propsData: {
      ...props
    }
  })
}

describe('DeliveryTimeInput', () => {

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
    const time = '12:30'
    const wrapper = factory()
    const childWrapper = wrapper.find('select')
    childWrapper.setValue(time)
    childWrapper.trigger('input')
    expect(wrapper.vm.$store.state.order.time).toBe(time)
  })
})

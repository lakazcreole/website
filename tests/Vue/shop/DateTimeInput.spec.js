import Vuex from 'vuex'
import { shallowMount, mount, createLocalVue } from '@vue/test-utils'
import expect from 'expect'

import DateTimeInput from '../../../resources/assets/js/components/shop/DateTimeInput'
import DatePicker from 'vuejs-datepicker'
import store from '../../../resources/assets/js/store'

const localVue = createLocalVue()
localVue.use(Vuex)

const factory = (props = {}) => {
  return shallowMount(DateTimeInput, {
    mocks: {
      $store: store
    },
    localVue,
    propsData: {
      ...props
    }
  })
}

describe('DateTimeInput', () => {

  it('has a select for date delivery', () => {
    const wrapper = factory()
    expect(wrapper.find('select.date').exists()).toBe(true)
  })

  it('defaults to the store date value', () => {
    const wrapper = factory()
    wrapper.vm.$store.commit('order/setDeliveryDays')
    wrapper.vm.$store.commit('order/setDate', wrapper.vm.$store.state.order.deliveryDays[0].value)
    expect(wrapper.find('select.date option:selected').text()).toBe('Demain')
  })

  it('mutates the store date when date select changes', () => {
    const wrapper = factory()
    const optionsWrapper = wrapper.find('select.date').findAll('option')
    optionsWrapper.at(1).setSelected()
    expect(wrapper.vm.$store.state.order.date).toBe(wrapper.vm.$store.state.order.deliveryDays[1].value)
  })

  it('has a select for time delivery', () => {
    const wrapper = factory()
    expect(wrapper.find('select.time').exists()).toBe(true)
  })

  it('has a help text when store time is null', () => {
    const wrapper = factory()
    wrapper.vm.$store.state.order.time = null
    expect(wrapper.find('select.time option').text()).toBe('Choisir un horaire')
  })

  it('defaults to the store time value if is different from null', () => {
    const time = '12:15'
    const hours = {
      morning: ['08:59', '12:15', '12:37'],
      evening: ['17:06', '23:01']
    }
    const wrapper = factory()
    wrapper.vm.$store.state.order.deliveryHours = hours
    wrapper.vm.$store.state.order.time = time
    expect(wrapper.find('select.time option:selected').text()).toBe(time)
  })

  it('mutates the store time when time select changes', () => {
    const wrapper = factory()
    const optionsWrapper = wrapper.find('select.time').findAll('option')
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
      expect(wrapper.find('select.time').text()).toContain(hour)
    })
  })

  it('emits a filled event when both fields are filled', () => {
    const wrapper = factory()
    wrapper.find('select.date').findAll('option').at(1).setSelected()
    wrapper.find('select.time').findAll('option').at(1).setSelected()
    expect(wrapper.emitted().filled).toBeTruthy()
  })
})

import Vuex from 'vuex'
import { shallowMount, mount, createLocalVue } from '@vue/test-utils'
import expect from 'expect'

import DeliveryInput from '../../resources/assets/js/components/DeliveryInput'
import OrderAddressInput from '../../resources/assets/js/components/OrderAddressInput'
import OrderDateTimeInput from '../../resources/assets/js/components/OrderDateTimeInput'
import store from '../../resources/assets/js/store'

const localVue = createLocalVue()
localVue.use(Vuex)

const factory = (props = {}) => {
  return shallowMount(DeliveryInput, {
    mocks: {
      $store: store
    },
    localVue,
    propsData: {
      ...props
    }
  })
}

describe('DeliveryInput', () => {

  it('initially displays the OrderAddressInput', () => {
    const wrapper = factory()
    expect(wrapper.find(OrderAddressInput).isVisible()).toBe(true)
  })

  it('initially hides the OrderDateTimeInput', () => {
    const wrapper = factory()
    expect(wrapper.find(OrderDateTimeInput).isVisible()).toBe(false)
  })

  it('hides OrderAddressInput and shows OrderDateTimeInput when address is defined', () => {
    const wrapper = factory()
    wrapper.vm.$store.state.order.address = {
      administrative: 'Centre-Val de Loire',
      city: 'Orléans',
      country: 'France',
      name: '53 Faubourg Saint-Vincent',
      postcode: '45000',
      type: 'address',
      value: '53 Faubourg Saint-Vincent, Orléans, Centre-Val de Loire, France'
    }
    wrapper.find(OrderAddressInput).vm.$emit('change')
    expect(wrapper.find(OrderAddressInput).isVisible()).toBe(false)
    expect(wrapper.find(OrderDateTimeInput).isVisible()).toBe(true)
  })

})


import Vuex from 'vuex'
import { shallowMount, mount, createLocalVue } from '@vue/test-utils'
import expect from 'expect'

import DeliveryInput from '../../resources/assets/js/components/DeliveryInput'
import OrderAddressInput from '../../resources/assets/js/components/OrderAddressInput'
import OrderDateTimeInput from '../../resources/assets/js/components/OrderDateTimeInput'
import SplittableCard from '../../resources/assets/js/components/SplittableCard'
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

  it('initially hides the SplittableCard', () => {
    const wrapper = factory()
    expect(wrapper.find(SplittableCard).isVisible()).toBe(false)
  })

  it('hides OrderAddressInput and shows OrderDateTimeInput when address is defined', () => {
    const wrapper = mount(DeliveryInput, {
      mocks: {
        $store: store
      },
      localVue
    })
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

  it('displays the address when OrderAddressInput is hidden', () => {
    const wrapper = mount(DeliveryInput, {
      mocks: {
        $store: store
      },
      localVue
    })
    wrapper.vm.$store.state.order.address = {
      value: '53 Faubourg Saint-Vincent, Orléans, Centre-Val de Loire, France'
    }
    wrapper.find(OrderAddressInput).vm.$emit('change')
    expect(wrapper.find(OrderAddressInput).isVisible()).toBe(false)
    expect(wrapper.text()).toContain(wrapper.vm.$store.state.order.address.value)
  })

  it('displays the date and time when OrderDateTimeInput is hidden', () => {
    const wrapper = mount(DeliveryInput, {
      mocks: {
        $store: store
      },
      localVue
    })
    wrapper.vm.$store.state.order.date = new Date()
    wrapper.vm.$store.state.order.time = '06:01'
    wrapper.vm.$store.state.order.dateTimeFilled = true
    expect(wrapper.find(OrderDateTimeInput).isVisible()).toBe(false)
    expect(wrapper.text()).toContain(wrapper.vm.$store.state.order.time)
    expect(wrapper.text()).toContain(wrapper.vm.$store.getters['order/date'])
  })

  it('emits a filled event when OrderDateTimeInput emits a filled event', () => {
    const wrapper = mount(DeliveryInput, {
      mocks: {
        $store: store
      },
      localVue
    })
    wrapper.find(OrderDateTimeInput).vm.$emit('filled')
    expect(wrapper.emitted().filled).toBeTruthy()
  })
})


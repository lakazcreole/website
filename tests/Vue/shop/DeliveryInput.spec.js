import Vuex from 'vuex'
import { shallowMount, mount, createLocalVue } from '@vue/test-utils'
import expect from 'expect'

import DeliveryInput from '../../../resources/assets/js/components/shop/DeliveryInput'
import AddressInput from '../../../resources/assets/js/components/shop/AddressInput'
import DateTimeInput from '../../../resources/assets/js/components/shop/DateTimeInput'
import SplittableCard from '../../../resources/assets/js/components/SplittableCard'
import store from '../../../resources/assets/js/store'

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

  it('initially displays the AddressInput', () => {
    const wrapper = factory()
    expect(wrapper.find(AddressInput).isVisible()).toBe(true)
  })

  it('initially hides the SplittableCard', () => {
    const wrapper = factory()
    expect(wrapper.find(SplittableCard).isVisible()).toBe(false)
  })

  it('hides AddressInput and shows DateTimeInput when only address is defined', () => {
    const wrapper = mount(DeliveryInput, {
      mocks: {
        $store: store
      },
      localVue
    })
    wrapper.vm.$store.state.order.date = null
    wrapper.vm.$store.state.order.time = null
    wrapper.vm.$store.state.order.address = {
      administrative: 'Centre-Val de Loire',
      city: 'Orléans',
      country: 'France',
      name: '53 Faubourg Saint-Vincent',
      postcode: '45000',
      type: 'address',
      value: '53 Faubourg Saint-Vincent, Orléans, Centre-Val de Loire, France'
    }
    wrapper.find(AddressInput).vm.$emit('change')
    expect(wrapper.find(AddressInput).isVisible()).toBe(false)
    expect(wrapper.find(DateTimeInput).isVisible()).toBe(true)
  })

  it('displays the address when AddressInput is hidden', () => {
    const wrapper = mount(DeliveryInput, {
      mocks: {
        $store: store
      },
      localVue
    })
    wrapper.vm.$store.state.order.address = {
      value: '53 Faubourg Saint-Vincent, Orléans, Centre-Val de Loire, France'
    }
    wrapper.find(AddressInput).vm.$emit('change')
    expect(wrapper.find(AddressInput).isVisible()).toBe(false)
    expect(wrapper.text()).toContain(wrapper.vm.$store.state.order.address.value)
  })

  it('displays the date and time when DateTimeInput is hidden', () => {
    const wrapper = mount(DeliveryInput, {
      mocks: {
        $store: store
      },
      localVue
    })
    wrapper.vm.$store.state.order.date = new Date()
    wrapper.vm.$store.state.order.time = '06:01'
    wrapper.vm.$store.state.order.dateTimeFilled = true
    expect(wrapper.find(DateTimeInput).isVisible()).toBe(false)
    expect(wrapper.text()).toContain(wrapper.vm.$store.state.order.time)
    expect(wrapper.text()).toContain(wrapper.vm.$store.getters['order/date'])
  })

  it('emits a filled event when DateTimeInput emits a filled event', () => {
    const wrapper = mount(DeliveryInput, {
      mocks: {
        $store: store
      },
      localVue
    })
    wrapper.find(DateTimeInput).vm.$emit('filled')
    expect(wrapper.emitted().filled).toBeTruthy()
  })
})


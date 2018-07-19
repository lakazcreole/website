import { shallowMount, createLocalVue } from '@vue/test-utils'
import expect from 'expect'

import Vuex from 'vuex'
import OrderAddressInput from '../../resources/assets/js/components/OrderAddressInput'
import store from '../../resources/assets/js/store'

const localVue = createLocalVue()
localVue.use(Vuex)

const factory = (props = {}) => {
  return shallowMount(OrderAddressInput, {
    mocks: {
      $store: store
    },
    localVue,
    propsData: {
      ...props
    }
  })
}

describe('OrderAddressInput', () => {

  it('has an input component', () => {
    const wrapper = factory()
    expect(wrapper.find('input[type="search"]').exists()).toBe(true)
  })

  // it('mutates the store address on field input', () => {
  //   const address = '53 Faubourg Saint-Vincent, Orléans, Centre-Val de Loire, France'
  //   const wrapper = factory()
  //   const childWrapper = wrapper.find('input[type="search"]')
  //   childWrapper.setValue(address)
  //   expect(wrapper.vm.$store.state.order.address).toBe(address)
  // })

  // it('mutates the store address when input changes', () => {
  //   const value = '53 Faubourg Saint-Vincent, Orléans, Centre-Val de Loire, France'
    // const address = {
    //   administrative: 'Centre-Val de Loire',
    //   city: 'Orléans',
    //   country: 'France',
    //   name: '53 Faubourg Saint-Vincent',
    //   postcode: '45000',
    //   type: 'address',
    //   value: value
    // }
  //   const wrapper = factory()
  //   const childWrapper = wrapper.find('input[type="search"]')
  //   childWrapper.element.value = value
  //   console.log(childWrapper.vm.placesAutocomplete)
  //   childWrapper.vm.placesAutocomplete.dispatchEvent(new Event('change'))
  //   expect(wrapper.vm.$store.state.order.address.administrative).toBe(address.administrative)
  //   expect(wrapper.vm.$store.state.order.address.city).toBe(address.city)
  //   expect(wrapper.vm.$store.state.order.address.country).toBe(address.country)
  //   expect(wrapper.vm.$store.state.order.address.name).toBe(address.name)
  //   expect(wrapper.vm.$store.state.order.address.postcode).toBe(address.postcode)
  //   expect(wrapper.vm.$store.state.order.address.type).toBe(address.type)
  //   expect(wrapper.vm.$store.state.order.address.value).toBe(address.value)
  // })
})

import { shallowMount, mount, createLocalVue } from '@vue/test-utils'
import expect from 'expect'
import Vuex from 'vuex'

import PromoCode from '../../../resources/js/components/shop/PromoCode.vue'
import FormInput from '../../../resources/js/components/FormInput.vue'
import store from '../../../resources/js/store'

const localVue = createLocalVue()
localVue.use(Vuex)

const factory = (props = {}) => {
  return shallowMount(PromoCode, {
    mocks: {
      $store: store
    },
    localVue,
    propsData: {
      ...props
    }
  })
}

describe('PromoCode', () => {

  it('initially displays a Add Code button', () => {
    const wrapper = factory()
    expect(wrapper.find('button.add').text()).toContain('Code promo')
  })

  it('initially has an hidden input field', () => {
    const wrapper = factory()
    expect(wrapper.find('input').isVisible()).toBe(false)
  })

  it('displays the input field when the Add button is pressed', () => {
    const wrapper = factory()
    wrapper.find('button.add').trigger('click')
    expect(wrapper.find('input').isVisible()).toBe(true)
  })

})

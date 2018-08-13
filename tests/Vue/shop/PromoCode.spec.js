import { shallowMount, mount, createLocalVue } from '@vue/test-utils'
import expect from 'expect'
import Vuex from 'vuex'

import PromoCode from '../../../resources/assets/js/components/shop/PromoCode.vue'
import FormInput from '../../../resources/assets/js/components/FormInput.vue'
import store from '../../../resources/assets/js/store'

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
    expect(wrapper.find('button').text()).toContain('Code promotionnel')
  })

  it('initially displays an input field', () => {
    const wrapper = factory()
    expect(wrapper.find(FormInput).exists()).toBe(true)
  })

})

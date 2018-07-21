import Vuex from 'vuex'
import { shallowMount, mount, createLocalVue } from '@vue/test-utils'
import expect from 'expect'

import Shop from '../../resources/assets/js/views/Shop'
import store from '../../resources/assets/js/store'

const localVue = createLocalVue()
localVue.use(Vuex)

const factory = (props = {}) => {
  return shallowMount(Shop, {
    mocks: {
      $store: store
    },
    localVue,
    propsData: {
      ...props
    }
  })
}

describe('Shop', () => {
})

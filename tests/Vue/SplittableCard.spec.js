import { shallowMount } from '@vue/test-utils'
import expect from 'expect'

import SplittableCard from '../../resources/assets/js/components/SplittableCard'

const factory = (props = {}) => {
  return shallowMount(SplittableCard, {
    slots: {
      top: '<div/>',
      bottom: '<div/>'
    },
    propsData: {
      ...props
    }
  })
}

describe('SplittableCard', () => {
  it('has two slots, top and bottom', () => {
    const wrapper = factory()
    expect(wrapper.find('.top').exists()).toBe(true)
  })
})

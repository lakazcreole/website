import { shallowMount } from '@vue/test-utils'
import expect from 'expect'

import SplittableCard from '../../resources/js/components/SplittableCard'

const factory = (props = {}) => {
  return shallowMount(SplittableCard, {
    slots: {
      top: '<div/>',
      bottom: '<div/>'
    },
    propsData: {
      split: false,
      ...props
    }
  })
}

describe('SplittableCard', () => {
  it('has two slots, top and bottom', () => {
    const wrapper = factory()
    expect(wrapper.find('.top').exists()).toBe(true)
    expect(wrapper.find('.bottom').exists()).toBe(true)
  })

  it('hides the top slot when split', () => {
    const wrapper = factory({ split: true })
    expect(wrapper.find('.top').isVisible()).toBe(false)
  })
})

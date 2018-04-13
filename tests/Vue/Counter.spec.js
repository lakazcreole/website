import { mount } from '@vue/test-utils'
import Counter from '../../resources/assets/js/components/Counter.vue'
import expect from 'expect'

describe('Counter', () => {

  it('defaults to a count of 0', () => {
    let wrapper = mount(Counter)
    expect(wrapper.vm.count).toBe(0)
  })

  it('displays the current count', () => {
    let wrapper = mount(Counter)
    expect(wrapper.find('.count').html()).toContain(0)
  })

})

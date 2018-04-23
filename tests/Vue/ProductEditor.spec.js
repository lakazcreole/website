import { shallow } from '@vue/test-utils'
import ProductEditor from '../../resources/assets/js/components/ProductEditor.vue'
import expect from 'expect'

const factory = (props = {}) => {
  return shallow(ProductEditor, {
    propsData: {
      id: 1,
      name: 'Test',
      disabled: false,
      apiToken: 'token',
      ...props
    }
  })
}

describe('ProductEditor', () => {

  it('displays the item\'s name', () => {
    const wrapper = factory({ name: 'Product'})
    expect(wrapper.text()).toContain('Product')
  })

  it('has a disable checkbox', () => {
    const wrapper = factory({ name: 'Product' })
    expect(wrapper.find('input[type="checkbox"]').exists()).toBe(true)
  })

})

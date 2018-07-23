import { shallowMount, mount, createLocalVue } from '@vue/test-utils'
import expect from 'expect'
import Vuex from 'vuex'

import OffersListItem from '../../../resources/assets/js/components/shop/OffersListItem'
import OffersList from '../../../resources/assets/js/components/shop/OffersList'
import store from '../../../resources/assets/js/store'

const localVue = createLocalVue()
localVue.use(Vuex)

const offersFactory = () => {
  return [{
    imageUrl: '/some/path.jpg',
    product: {
      id: 1,
      name: 'Some offer',
      price: 2,
      description: null
    }
  }, {
    imageUrl: '/other/path.jpg',
    product: {
      id: 2,
      name: 'Other offer ',
      price: 3,
      description: 'Better offer'
    }
  }]
}

const factory = (props = {}) => {
  const wrapper = shallowMount(OffersList, {
    mocks: {
      $store: store
    },
    localVue,
    propsData: {
      ...props
    }
  })
  return wrapper
}

describe('OffersList', () => {

  it('displays all the products', () => {
    const wrapper = factory()
    wrapper.vm.$store.state.products.offers = offersFactory()
    wrapper.vm.$store.state.products.loadedOffers = true
    expect(wrapper.findAll(OffersListItem).length).toBe(wrapper.vm.$store.state.products.offers.length)
  })

  it('updates the store when OffersListItem fires and add event', () => {
    const wrapper = factory({
      offers: offersFactory()
    })
    const childWrapper = wrapper.find(OffersListItem)
    wrapper.vm.$store.state.cart.items = []
    wrapper.vm.$store.state.products.loadedOffers = true
    childWrapper.vm.$emit('add')
    expect(wrapper.vm.$store.state.cart.items.filter((item) => item.id === childWrapper.props().productId)).not.toEqual([])
  })

})

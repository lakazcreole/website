import shop from '../../api/shop'

export default {
  namespaced: true,

  state: {
    all: [],
    offers: [],
    loadedProducts: false,
    loadedOffers: false,
    error: false
  },

  getters: {

  },

  mutations: {
    setProducts (state, products) {
      state.all = products
    },
    setOffers (state, offers) {
      state.offers = offers
    },
    fetchProductsSuccess (state) {
      state.loadedProducts = true
    },
    fetchOffersSuccess (state) {
      state.loadedOffers = true
    },
    fetchError (state) {
      state.error = true
    }
  },

  actions: {
    fetchProducts ({ commit }) {
      shop.getProducts()
        .then(products => {
          commit('setProducts', products)
          commit('fetchProductsSuccess')
        })
        .catch(() => {
          commit('fetchError')
        })
    },
    fetchOffers ({ commit }) {
      shop.getOffers()
        .then(offers => {
          commit('setOffers', offers)
          commit('fetchOffersSuccess')
        })
        .catch(() => {
          commit('fetchError')
        })
    }
  }
}

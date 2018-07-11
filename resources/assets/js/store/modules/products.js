import axios from 'axios'

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
      axios.get('/api/products?order=true').then(response => {
        if (response.status === 200) {
          commit('setProducts', response.data.data)
          commit('fetchProductsSuccess')
        }
      }).catch(() => {
        commit('fetchError')
      })
    },
    fetchOffers ({ commit}) {
      axios.get('/api/products/offers').then(response => {
        if (response.status === 200) {
          commit('setOffers', response.data.data)
          commit('fetchOffersSuccess')
        }
      }).catch(() => {
        commit('fetchError')
      })
    }
  }
}

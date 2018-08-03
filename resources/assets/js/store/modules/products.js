import shop from '../../api/shop'

export default {
  namespaced: true,

  state: {
    all: [],
    offers: [],
    types: [],
    currentCategory: null,
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
    setTypes (state, types) {
      state.types = types
    },
    setCurrentCategory (state, currentCategory) {
      state.currentCategory = currentCategory
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
    },
    fetchTypes ({ commit }) {
      const types = [{
        key: 'starter',
        name: 'Entrées'
      }, {
        key: 'main',
        name: 'Plats'
      }, {
        key: 'desert',
        name: 'Desserts'
      },
      {
        key: 'drink',
        name: 'Boissons'
      }]
      commit('setTypes', types)
    }
  }
}

export default {
  namespaced: true,

  state: {
    items: []
  },

  getters: {
    items (state, getters, rootState) {
      return state.items.map(({ id, quantity }) => {
        const product = rootState.products.all.find(product => product.id === id)
        return {
          id: product.id,
          name: product.name,
          price: product.price,
          quantity
        }
      })
    }
  },

  mutations: {
    setItems (state, items) {
      state.items = items
    },
    addItem (state, { id }) {
      state.items.push({
        id,
        quantity: 1
      })
    },
    incrementItemQuantity (state, { id }) {
      const item = state.items.find(item => item.id === id)
      item.quantity++
    }
  },

  actions: {
    addProduct ({ state, commit }, product) {
      const cartItem = state.items.find(item => item.id === product.id)
      if (!cartItem) {
        commit('addItem', { id: product.id })
      } else {
        commit('incrementItemQuantity', cartItem)
      }
    },
    removeProduct ({ state, commit }, productId) {
      const cartItems = state.items.filter(item => item.id !== productId)
      commit('setItems', cartItems)
    }
  }
}

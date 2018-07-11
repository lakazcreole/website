export default {
  namespaced: true,

  state: {
    items: []
  },

  getters: {

  },

  mutations: {
    pushProductToCart (state, { id }) {
      state.items.push({
        id,
        quantity: 1
      })
    },
    incrementItemQuantity (state, { id }) {
      const cartItem = state.items.find(item => item.id === id)
      cartItem.quantity++
    }
  },

  actions: {

  }
}

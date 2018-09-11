export default {
  namespaced: true,

  state: {
    items: []
  },

  getters: {
    items (state, getters, rootState) {
      return state.items.map((item) => {
        const product = rootState.products.all.find(p => p.id === item.id)
        return {
          id: product.id,
          name: product.name,
          price: product.price,
          quantity: item.quantity
        }
      })
    },
    totalPrice (state, getters) {
      return getters.items.reduce((accumulator, item) => accumulator + item.quantity * item.price, 0)
    },
    deliveryPrice (state, getters) {
      if (getters.totalPrice === 0 || getters.totalPrice >= 15) return 0
      else if (getters.totalPrice <= 13) return 2
      else return 15 - getters.totalPrice
    },
    minimumReached (state, getters) {
      return getters.totalPrice + getters.deliveryPrice >= 8
    },
    hasDiscountRequiredProducts (state, getters, rootState) {
      if (rootState.order.discount === null) return true

      const productsIds = rootState.order.discount.items.reduce((acc, item) => {
        return acc.concat(item.products)
      }, []).map(product => {
        return product.id
      }).filter(function (value, index, self) {
        return self.indexOf(value) === index
      })

      for (let i = 0; i < state.items.length; i++) {
        if (productsIds.includes(state.items[i].id)) return true
      }
      return false
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
        commit('addItem', product)
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

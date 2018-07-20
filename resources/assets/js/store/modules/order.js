
export default {
  namespaced: true,

  state: {
    date: null,
    time: null,
    deliveryHours: {
      morning: ['11:30', '11:45', '12:00', '12:15', '12:30', '12:45', '13:00'],
      evening: ['19:45', '20:00', '20:15', '20:30', '20:45', '21:00']
    },
    address: {},
    deliveryTimeFilled: false
  },

  getters: {
    address (state) {
      return state.address.value
    },
    date (state) {
      if (state.date) return state.date.toLocaleDateString('fr-FR', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })
      return null
    }
  },

  mutations: {
    setDate (state, date) {
      state.date = date
    },
    setTime (state, time) {
      state.time = time
    },
    setAddress (state, address) {
      state.address = address
    },
    setDeliveryTimeFilled (state, filled) {
      state.deliveryTimeFilled = filled
    }
  },

  actions: {
    updateDeliveryTimeFilled ({ commit, state }) {
      if (state.date !== null && state.time !== null) {
      } else {
        commit('set')
      }
    }
  }
}

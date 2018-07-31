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
    dateTimeFilled: false,
    showMobileCart: false
  },

  getters: {
    address (state) {
      return state.address.value
    },
    date (state) {
      if (state.date) return state.date.toLocaleDateString('fr-FR', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })
      return null
    },
    deliveryInputFilled (state, getters) {
      return state.dateTimeFilled && getters.address
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
    setDateTimeFilled (state, filled) {
      state.dateTimeFilled = filled
    },
    setShowMobileCart (state, show) {
      state.showMobileCart = show
    }
  },

  actions: {
    toggleMobileCart ({ state, commit }) {
      commit('setShowMobileCart', !state.showMobileCart)
    }
  }
}

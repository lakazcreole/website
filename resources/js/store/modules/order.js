export default {
  namespaced: true,

  state: {
    address: {},
    date: null,
    time: null,
    customer: {
      firstName: '',
      lastName: '',
      email: '',
      phone: ''
    },
    allergies: '',
    information: '',
    promoCode: '',
    discount: null,
    finalOrder: null,
    errors: {},
    serverError: false,
    deliveryDays: [],
    deliveryHours: {
      morning: ['11:30', '11:45', '12:00', '12:15', '12:30', '12:45', '13:00'],
      evening: ['19:45', '20:00', '20:15', '20:30', '20:45', '21:00']
    },
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
    setCustomerFirstName (state, firstName) {
      state.customer.firstName = firstName
    },
    setCustomerLastName (state, lastName) {
      state.customer.lastName = lastName
    },
    setCustomerEmail (state, email) {
      state.customer.email = email
    },
    setCustomerPhone (state, phone) {
      state.customer.phone = phone
    },
    setAllergies (state, allergies) {
      state.allergies = allergies
    },
    setInformation (state, information) {
      state.information = information
    },
    setPromoCode (state, promoCode) {
      state.promoCode = promoCode
    },
    setDiscount (state, discount) {
      state.discount = discount
    },
    setErrors (state, errors) {
      state.errors = errors
    },
    serverError (state) {
      state.serverError = true
    },
    setFinalOrder (state, finalOrder) {
      state.finalOrder = finalOrder
    },
    setDeliveryDays (state) {
      for (let i = 0; i < 7; i++) {
        const day = new Date()
        day.setDate(day.getDate() + (i + 1))
        state.deliveryDays[i] = {
          string: i === 0 ? 'Demain' : day.toLocaleDateString('fr-FR', { weekday: 'long', month: 'long', day: 'numeric' }).replace(/^\w/, c => c.toUpperCase()),
          value: day
        }
      }
    },
    setDateTimeFilled (state, filled) {
      state.dateTimeFilled = filled
    },
    setShowMobileCart (state, show) {
      state.showMobileCart = show
    }
  },

  actions: {
    fetchDeliveryDays ({ state, commit }) {
      commit('setDeliveryDays')
      commit('setDate', state.deliveryDays[0].value)
    },
    toggleMobileCart ({ state, commit }) {
      commit('setShowMobileCart', !state.showMobileCart)
    }
  }
}

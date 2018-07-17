const state = {
  date: null,
  time: null
}

const getters = {

}

const mutations = {
  setDate (state, date) {
    state.date = date
  },
  setTime (state, time) {
    state.time = time
  }
}

const actions = {

}

export default {
  namespaced: true,

  state,
  getters,
  mutations,
  actions
}

import Vue from 'vue'
import Vuex from 'vuex'
import 'es6-promise/auto'

import products from './modules/products'

Vue.use(Vuex) // eslint-disable-line no-undef

export default new Vuex.Store({
  strict: process.env.NODE_ENV !== 'production', // eslint-disable-line no-undef
  modules: {
    products
  }
})

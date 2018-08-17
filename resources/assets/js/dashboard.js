/* eslint-disable import/first */

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap')

window.Vue = require('vue')

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import Datepicker from 'vuejs-datepicker'
import DiscountProductsList from './components/dashboard/DiscountProductsList'

// eslint-disable-next-line no-unused-vars, no-undef
const app = new Vue({
  el: '#app',
  components: {
    Datepicker,
    DiscountProductsList
    // 'product-editor': require('./components/ProductEditor.vue').default
  }
})

/* eslint-disable import/first */

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap')

window.Vue = require('vue')

/*
 * My imports
 */

// import VueSticky from 'vue-sticky'
import PortalVue from 'portal-vue'
import VueModal from 'vue-js-modal'
import VueScrollTo from 'vue-scrollto'
import VueScrollactive from 'vue-scrollactive'

// const VueScrollTo = require('vue-scrollto') // eslint-disable-line no-unused-vars

import ContactButton from './components/ContactButton'
import ContactModal from './components/ContactModal'
import ShopClosedModal from './components/ShopClosedModal'
import OrderButton from './components/OrderButton'
import NewsletterForm from './components/NewsletterForm'
import Shop from './views/Shop'

import store from './store'

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use(PortalVue) // eslint-disable-line no-undef
Vue.use(VueModal, { componentName: 'vue-modal' }) // eslint-disable-line no-undef
Vue.use(VueScrollTo, { // eslint-disable-line no-undef
  container: 'body',
  duration: 500,
  easing: 'ease',
  offset: -100,
  cancelable: true,
  onStart: false,
  onDone: false,
  onCancel: false,
  x: false,
  y: true
})
Vue.use(VueScrollactive) // eslint-disable-line no-undef

// eslint-disable-next-line no-unused-vars, no-undef
const app = new Vue({
  el: '#app',
  store,
  components: {
    ContactButton,
    ContactModal,
    ShopClosedModal,
    OrderButton,
    NewsletterForm,
    Shop
  },
  data () {
    return {
      showNav: false
    }
  },
  methods: {
    scrollToMenu: function () {
      const options = {
        container: 'body',
        easing: 'ease-in',
        offset: -100,
        cancelable: true,
        onDone: function () {
          // scrolling is done
        },
        onCancel: function () {
          // scrolling has been interrupted
        },
        x: false,
        y: true
      }
      this.$scrollTo('#la-carte', 500, options)
    },
    showShopClosedModal () {
      this.$modal.show('shop-closed-modal')
    }
  }
})

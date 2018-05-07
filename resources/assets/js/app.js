//
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

import VueSticky from 'vue-sticky'
import PortalVue from 'portal-vue'
import CheckView from 'vue-check-view'
import VueModal from 'vue-js-modal'
import VTooltip from 'v-tooltip'

const VueScrollTo = require('vue-scrollto') // eslint-disable-line no-unused-vars

import ContactButton from './components/ContactButton'
import ContactModal from './components/ContactModal'

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use(PortalVue) // eslint-disable-line no-undef
Vue.use(CheckView) // eslint-disable-line no-undef
Vue.use(VueModal, { componentName: 'vue-modal' }) // eslint-disable-line no-undef
Vue.use(VTooltip) // eslint-disable-line no-undef

// eslint-disable-next-line no-unused-vars, no-undef
const app = new Vue({
    el: '#app',
    components: {
        ContactButton,
        ContactModal,
        'newsletter-form': require('./components/NewsletterForm.vue').default,
        'order-manager': require('./components/OrderManager.vue').default
    },
    directives: {
        'sticky': VueSticky
    },
    methods: {
        openOrder: function() {
            this.subject = 'Commande'
            this.message = 'Cela a l\'air délicieux, je souhaiterais commander toute la carte !'
            this.showContactModal = true
        },
        scrollToMenu: function() {
            const options = {
                container: 'body',
                easing: 'ease-in',
                offset: -100,
                cancelable: true,
                onDone: function() {
                  // scrolling is done
                },
                onCancel: function() {
                  // scrolling has been interrupted
                },
                x: false,
                y: true
            }
            this.$scrollTo('#la-carte', 500, options)
        }
    }
});

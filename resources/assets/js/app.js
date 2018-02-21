
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

const VueScrollTo = require('vue-scrollto')

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    components: {
        'contact-modal': require('./components/ContactModal.vue'),
        'newsletter-form': require('./components/NewsletterForm.vue'),
        'order-manager': require('./components/OrderManager.vue')
    },
    directives: {
        'sticky': VueSticky
    },
    data: {
        showContactModal: false,
        subject: '',
        message: ''
    },
    methods: {
        openOrder: function() {
            this.subject = 'Commande'
            this.message = 'Cela a l\'air délicieux, je souhaiterais commander toute la carte !'
            this.showContactModal = true
        },
        scrollToMenu: function(e) {
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

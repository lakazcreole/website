<template>
  <div v-if="finished" class="container">
    <div style="height: 259px;" class="d-flex">
      <div class="my-auto w-100">
        <p class="my-3 text-center">Merci de votre commande ! Je reviendrai rapidement vers vous par le biais de votre adresse e-mail <strong>{{ order.customer.email }}</strong>.</p>
      </div>
    </div>
  </div>
  <div v-else>
    <div v-if="error" class="container">
      <p class="my-3 text-center">Le service de commande est indisponible. Veuillez réessayer plus tard.</p>
    </div>
    <div v-else-if="loadedProducts && loadedOffers" class="container">
      <div v-if="showTimeSelector" style="height: 259px;" class="d-flex">
        <div class="my-auto w-100">
          <h2 class="mb-3">Livraison</h2>
          <DeliveryTimeForm @submit="handleDeliveryTimeFormSubmit" :on-date-input="handleDateInput" :on-time-input="handleTimeInput"/>
        </div>
      </div>
      <div v-else>
        <!-- Delivery Time Modal -->
        <modal name="delivery-time-modal">
          <h3 slot="header">Livraison</h3>
          <DeliveryTimeSelector
            slot="body"
            :default-date="order.date"
            :default-time="order.time"
            :on-date-input="value => { this.editedDate = value }"
            :on-time-input="value => { this.editedTime = value }"
          />
          <div slot="footer" class="text-right">
            <button type="button" class="btn btn-secondary ml-2" @click="disableDeliveryTimeModal">Annuler</button>
            <button type="button" class="btn btn-primary ml-2" @click="handleDeliveryTimeModalSave">Modifier</button>
          </div>
        </modal>
        <OrderOffersMenu v-if="showMenu" :offers="productOffers" @addProduct="addOrderLine"/>
        <div class="row">
          <div class="col-sm-6 col-lg-8">
            <order-menu v-if="showMenu" :products="products" :handle-add="addOrderLine"/>
            <delivery-form
              v-if="showDeliveryForm"
              :errors="order.errors"
              :on-first-name-input="value => { this.order.customer.firstName = value }"
              :on-last-name-input="value => { this.order.customer.lastName = value }"
              :on-email-input="value => { this.order.customer.email = value }"
              :on-phone-input="value => { this.order.customer.phone = value }"
              :on-address-one-input="value => { this.order.address1 = value }"
              :on-address-two-input="value => { this.order.address2 = value }"
              :on-address-three-input="value => { this.order.address3 = value }"
              :on-city-input="value => { this.order.city = value }"
              :on-zip-input="value => { this.order.zip = value }"
            />
          </div>
          <div class="col-sm-6 col-lg-4">
            <div v-if="showCart" v-sticky="{ zIndex: 1019, stickyTop: 115 }">
              <div v-if="!showDeliveryForm" v-show="!showCartModal" class="d-block d-sm-none">
                <div v-show="showFixedCartButton" class="fixed-bottom container text-center mb-3">
                  <transition name="fade">
                    <cart-button :items="order.lines" @click="enableCartModal"/>
                  </transition>
                </div>
                <div v-view="viewHandler" class="text-center mb-3">
                  <cart-button :items="order.lines" @click="enableCartModal"/>
                </div>
              </div>
              <!-- Cart modal -->
              <modal name="cart-modal">
                <h3 slot="header">Panier</h3>
                <portal-target name="cart-modal" slot="body"/>
                <div slot="footer">
                  <button v-if="showMenu" class="validate-cart btn btn-lg btn-block btn-primary" :disabled="!canOrder" @click="validateCart">Commander</button>
                  <button v-if="showDeliveryForm" class="btn btn-link btn-block" @click="editCart">Modifier</button>
                </div>
              </modal>
              <div class="d-none d-sm-block">
                <div class="d-flex justify-content-between align-items-center">
                  <h2>Panier</h2>
                  <button v-show="showDeliveryForm" class="btn btn-link" @click="editCart">Modifier</button>
                </div>
                <portal-target name="cart"/>
                <portal :to="showCartModal ? 'cart-modal' : 'cart'">
                  <cart
                    :items="order.lines"
                    :editable="showMenu"
                    @minimumReached="minimumReached = true"
                    @minimumDropped="minimumReached = false"
                    @removeItem="removeOrderLine"
                  />
                  <div class="my-3">
                    <div v-if="showDeliveryForm || showCartModal " class="form-group">
                      <label for="inputInformation">Informations</label>
                      <textarea
                        class="form-control"
                        placeholder="Allergies, etc."
                        v-model="order.information"
                      />
                    </div>
                    <p class="mb-0 text-center">
                      Livraison le <a href="#" class="link" title="Modifier" @click.prevent="handleDeliveryTimeEdit()">{{ readableDate }} à {{ order.time }}</a>.<br>
                      Paiement en <strong>espèces, tickets restaurant ou Lydia</strong>.
                    </p>
                  </div>
                </portal>
                <button v-if="showMenu" class="validate-cart btn btn-lg btn-block btn-primary mt-3" :disabled="!canOrder" @click="validateCart">Commander</button>
              </div>
              <div v-if="showDeliveryForm" class="mt-3">
                <button class="btn btn-lg btn-block btn-primary" @click="handleOrder()" :disabled="!deliveryFormFilled">Commander</button>
                <button class="d-block d-sm-none btn btn-block btn-link" @click.prevent="enableCartModal">Retour au panier</button>
                <div v-if="order.serverError" class="mt-3 text-center">
                  <p class="mb-0 text-danger">Une erreur s'est produite. Veuillez réessayer plus tard.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import VueSticky from 'vue-sticky'

import Modal from './Modal'
import OrderOffersMenu from './OrderOffersMenu'
import OrderMenu from './OrderMenu'
import Cart from './Cart'
import CartButton from './CartButton'
import DeliveryForm from './DeliveryForm'
import DeliveryTimeForm from './DeliveryTimeForm'
import DeliveryTimeSelector from './DeliveryTimeSelector'

export default {
  components: {
    Modal,
    OrderMenu,
    OrderOffersMenu,
    Cart,
    CartButton,
    DeliveryForm,
    DeliveryTimeForm,
    DeliveryTimeSelector
  },

  directives: {
    'sticky': VueSticky
  },

  data() {
    return {
      loadedProducts: false,
      loadedOffers: false,
      error: false,
      products: null,
      productOffers: null,
      editedDate: null,
      editedTime: null,
      order: {
        lines: [],
        date: null,
        time: null,
        information: '',
        customer: {
          firstName: '',
          lastName: '',
          email: '',
          phone: ''
        },
        address1: '',
        address2: '',
        address3: '',
        city: '',
        zip: '',
        errors: null,
        serverError: false,
      },
      showTimeSelector: true,
      showCart: false,
      showFixedCartButton: false,
      showCartModal: false,
      showMenu: false,
      showDeliveryForm: false,
      finished: false,
      minimumReached: false
    }
  },
  mounted() {
    this.fetchProducts()
    this.fetchProductOffers()
  },
  computed: {
    readableDate() {
      return this.order.date.toLocaleDateString('fr-FR', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })
    },
    deliveryFormFilled() {
      return this.order.customer.firstName !== '' && this.order.customer.lastName !== '' && this.order.customer.email !== '' && this.order.customer.phone !== '' &&
        this.order.address1 !== '' && this.order.city !== '' && this.order.zip !== ''
    },
    canOrder() {
      return this.order.lines && this.minimumReached
    }
  },
  methods: {
    fetchProducts() {
      axios.get('/api/products').then(response => {
        if (response.status === 200) {
          this.products = response.data.data
          this.loadedProducts = true
        }
      }).catch(() => {
        // console.log(error)
        this.error = true
      })
    },
    fetchProductOffers () {
      axios.get('/api/products/offers').then(response => {
        if (response.status === 200) {
          this.productOffers = response.data.data
          this.loadedOffers = true
        }
      }).catch(() => {
        // console.log(error)
        this.error = true
      })
    },
    addOrderLine(product, side = null) {
      this.addProductLine(product)
      if (side) this.addSideLine(side)
    },
    addProductLine(product) {
      for (var i = this.order.lines.length - 1; i >= 0; i--) {
        if (this.order.lines[i].id === product.id) {
          this.order.lines[i].quantity++
          return
        }
      }
      this.order.lines.push({
        id: product.id,
        name: product.name,
        price: Number(product.price),
        quantity: 1
      })
    },
    addSideLine(side) {
      for (var i = this.order.lines.length - 1; i >= 0; i--) {
        if (this.order.lines[i].id === side.id) {
          this.order.lines[i].quantity++
          return
        }
      }
      this.order.lines.push({
        id: side.id,
        name: side.name,
        price: Number(side.price),
        quantity: 1
      })
    },
    removeOrderLine(productId) {
      this.order.lines.splice(this.order.lines.find((product) => product.id === productId), 1)
    },
    handleDateInput(value) {
      this.order.date = value
    },
    handleTimeInput(value) {
      this.order.time = value
    },
    handleDeliveryTimeFormSubmit() {
      this.showTimeSelector = false
      this.showMenu = true
      this.showCart = true
    },
    handleDeliveryTimeEdit() {
      this.editedDate = this.order.date
      this.editedTime = this.order.time
      this.enableDeliveryTimeModal()
    },
    handleDeliveryTimeModalSave() {
      this.order.date = this.editedDate
      this.order.time = this.editedTime
      this.disableDeliveryTimeModal()
    },
    validateCart() {
      this.showMenu = false
      this.showDeliveryForm = true
      this.disableCartModal()
      // this.showCartModal = false
    },
    editCart() {
      this.showMenu = true
      this.showDeliveryForm = false
      this.disableCartModal()
      // this.showCartModal = false
    },
    handleOrder() {
      const order = {
        orderLines: this.order.lines,
        date: this.order.date.toLocaleDateString('fr-FR'),
        time: this.order.time,
        information: this.order.information,
        customer: {
          firstName: this.order.customer.firstName,
          lastName: this.order.customer.lastName,
          email: this.order.customer.email,
          phone: this.order.customer.phone
        },
        address: {
          address1: this.order.address1,
          address2: this.order.address2,
          address3: this.order.address3,
          city: this.order.city,
          zip: this.order.zip
        },
      }
      // console.log(order)
      axios.post('/api/orders', order)
        .then(() => {
          this.finished = true
        })
        .catch((error) => {
          if (error.response && error.response.status === 422) {
            this.order.errors = error.response.data
            // console.log(this.order.errors)
          } else {
            this.order.serverError = true
          }
        })
    },
    viewHandler (e) {
      if (e.type === 'exit') {
        this.showFixedCartButton = true
      } else if (e.type === 'enter') {
        this.showFixedCartButton = false
      }
    },
    enableDeliveryTimeModal() {
      this.$modal.show('delivery-time-modal')
    },
    disableDeliveryTimeModal() {
      this.$modal.hide('delivery-time-modal')
    },
    enableCartModal() {
      this.showCartModal = true
      this.$modal.show('cart-modal')
    },
    disableCartModal() {
      this.showCartModal = false
      this.$modal.hide('cart-modal')
    }
  }
}
</script>

<style scoped>
  .vue-affix {
    width: 100%;
  }
</style>

<template>
  <div>
    <div v-if="completed">
      <div class="flex" style="background-image: url('/images/order_header.jpg'); background-size: cover; background-position: center">
        <div class="mx-auto w-full max-w-sm px-3 sm:px-0 my-20">
          <OrderCompleted/>
        </div>
      </div>
    </div>
    <div v-else>
      <transition enter-active-class="slideInDown" leave-active-class="slideOutUp" duration="800">
        <div v-show="showMobileCart" :class="`shrink-transition overflow-hidden ${mobileCartHeightClass} bg-black text-white px-3`">
          <Cart id="mobile-cart" :editable="editingCart" @edit="editCart"/>
          <div v-show="showAllergiesInput" class="mt-5">
            <label for="allergies" class="block font-semibold text-grey text-sm mb-3">Allergies</label>
            <textarea
              id="allergies"
              v-model="allergies"
              placeholder="Ajouter un commentaire"
              rows="2"
              class="p-4 w-full rounded-lg shadow-lg text-sm text-grey-darker"
            />
          </div>
          <PrimaryButton :disabled="!canOrder" class="mt-6 w-full" @click="checkout">Commander</PrimaryButton>
        </div>
      </transition>
      <transition enter-active-class="fadeInUp" leave-active-class="fadeOutDown" duration="800">
        <div v-show="!showMobileCart">
          <div :class="`z-30 sticky pin-t shrink-transition ${headerHeightClass} shadow-md`">
            <div class="z-0 w-full h-full" style="background-image: url('/images/order_header.jpg'); background-size: cover; background-position: center"/>
            <div class="absolute pin-t z-0 bg-black opacity-25 w-full h-full"/>
            <div class="absolute pin-t mt-10 w-full flex justify-center">
              <div class="mx-3 sm:mx-0 max-w-xs sm:max-w-sm w-full">
                <h1 class="text-center text-grey-lightest font-title font-normal text-5xl mb-3" style="text-shadow: 2px 2px 3px black">Commande</h1>
                <DeliveryInput
                  @filled="inputFilled"
                  @editingAddress="editAddress()"
                  @editedAddress="editedAddress()"
                />
              </div>
            </div>
          </div>
          <transition name="slide" enter-active-class="slideInUp" leave-active-class="slideOutDown">
            <div v-show="deliveryStepDone" class="container mx-auto py-20 md:py-16">
              <OffersList v-show="showMenu" class="mb-8"/>
              <div class="flex justify-end">
                <div class="hidden sm:block flex-1">
                  <transition enter-active-class="fadeInLeft" leave-active-class="fadeOutLeft">
                    <ProductsListNav v-show="showMenu" class="sticky mr-5 " style="top: 250px"/>
                  </transition>
                </div>
                <div class="px-3 sm:px-0 w-full sm:max-w-sm flex-none">
                  <transition-group enter-active-class="fadeInLeft" leave-active-class="fadeOutLeft">
                    <div v-show="showCheckOut" key="checkout">
                      <CustomerInput/>
                      <PrimaryButton class="mt-10 w-full" @click="handleOrder">Commander</PrimaryButton>
                    </div>
                    <ProductsList v-show="showMenu" key="products"/>
                  </transition-group>
                </div>
                <div class="hidden sm:block flex-1">
                  <div :style="cartStyle" class="sticky ml-5 mr-3">
                    <Cart :editable="editingCart" @edit="editCart">
                      <Alert v-show="showCheckOut && allergies.length" color="blue" class="mb-5">
                        <p>{{ allergies }}</p>
                      </Alert>
                    </Cart>
                    <div v-show="showMenu && showAllergiesInput" class="mt-5">
                      <label for="allergies" class="block font-semibold text-grey text-sm mb-3">Allergies</label>
                      <textarea
                        id="allergies"
                        v-model="allergies"
                        placeholder="Ajouter un commentaire"
                        rows="2"
                        class="p-4 w-full rounded-lg shadow-lg text-sm text-grey-darker"
                      />
                    </div>
                    <PrimaryButton v-show="showMenu" :disabled="!canOrder" class="mt-6 w-full" @click="checkout">Commander</PrimaryButton>
                  </div>
                </div>
              </div>
            </div>
          </transition>
        </div>
      </transition>
    </div>
  </div>
</template>

<script>
import { mapState, mapGetters } from 'vuex'
import VueSticky from 'vue-sticky'
import axios from 'axios'

import Alert from '../components/Alert'
import PrimaryButton from '../components/PrimaryButton'

import OrderCompleted from '../components/shop/OrderCompleted'
import DeliveryInput from '../components/shop/DeliveryInput'
import CustomerInput from '../components/shop/CustomerInput'
import ProductsList from '../components/shop/ProductsList'
import ProductsListNav from '../components/shop/ProductsListNav'
import OffersList from '../components/shop/OffersList'
import Cart from '../components/shop/Cart'

export default {
  components: {
    Alert,
    PrimaryButton,
    OrderCompleted,
    DeliveryInput,
    CustomerInput,
    ProductsList,
    ProductsListNav,
    OffersList,
    Cart
  },

  directives: {
    'sticky': VueSticky
  },

  data () {
    return {
      deliveryStepDone: false,
      editingAddress: false,
      editingCart: true,
      showMenu: false,
      showCheckOut: false
    }
  },

  computed: {
    ...mapState('order', [
      'showMobileCart',
      'completed'
    ]),
    ...mapGetters({
      deliveryInputFilled: 'order/deliveryInputFilled',
      canOrder: 'cart/minimumReached'
    }),
    allergies: {
      get () {
        return this.$store.state.order.allergies
      },
      set (value) {
        this.$store.commit('order/setAllergies', value)
      }
    },
    showAllergiesInput () {
      return this.$store.state.cart.items.length
    },
    contentHeightClass () {
      return this.showMobileCart ? 'h-0' : 'h-full'
    },
    mobileCartHeightClass () {
      return this.showMobileCart ? 'h-full py-10' : 'h-0'
    },
    cartStyle () {
      return this.showCheckOut ? '' : 'top: 250px'
    },
    headerHeightClass () {
      if (this.deliveryStepDone) {
        // editing datetime
        if (!this.deliveryInputFilled) return 'h-82vh sm:h-67vh lg:h-52vh xl:h-42vh'
        // editing address
        if (this.editingAddress) return 'h-53vh lg:h-34vh'
        // not editing
        return 'h-34vh md:h-22vh lg:h-24vh'
      }
      // Values when menu is not shown
      return this.deliveryInputFilled ? 'h-20vh' : 'h-82vh md:h-52vh xl:h-58vh' // sm:h-70vh
    }
  },

  mounted () {
    this.$store.dispatch('products/fetchProducts')
    this.$store.dispatch('products/fetchOffers')
    this.$store.dispatch('products/fetchTypes')
    this.$store.dispatch('order/fetchDeliveryDays')
  },

  methods: {
    inputFilled () {
      this.deliveryStepDone = true
      if (!this.showCheckOut) {
        this.showMenu = true
      }
    },
    editAddress () {
      this.editingAddress = this.deliveryStepDone
    },
    editedAddress () {
      this.editingAddress = false
    },
    checkout () {
      if (this.showMobileCart) {
        this.$store.dispatch('order/toggleMobileCart')
      }
      this.showMenu = false
      this.editingCart = false
      this.showCheckOut = true
    },
    editCart () {
      if (this.showMobileCart) {
        this.$store.dispatch('order/toggleMobileCart')
      }
      this.showMenu = true
      this.editingCart = true
      this.showCheckOut = false
    },
    handleOrder () {
      const order = {
        orderLines: this.$store.getters['cart/items'],
        date: this.$store.state.order.date.toLocaleDateString('fr-FR'),
        time: this.$store.state.order.time,
        information: this.$store.state.order.allergies,
        customer: {
          firstName: this.$store.state.order.customer.firstName,
          lastName: this.$store.state.order.customer.lastName,
          email: this.$store.state.order.customer.email,
          phone: this.$store.state.order.customer.phone
        },
        address: {
          address1: this.$store.state.order.address.name,
          address2: null,
          address3: this.$store.state.order.information,
          city: this.$store.state.order.address.city,
          zip: this.$store.state.order.address.postcode
        }
      }
      console.log(order)
      // console.log(order)
      axios.post('/api/orders', order)
        .then(() => {
          this.$store.commit('order/completed')
        })
        .catch((error) => {
          if (error.response && error.response.status === 422) {
            this.$store.commit('order/setErrors', error.response.data.errors)
          } else {
            this.$store.commit('order/serverError')
          }
        })
    }
  }
}
</script>

<style lang="scss">
.shrink-transition {
  transition: height 0.8s ease,
              width 0.8s ease,
              padding 0.8s ease;
}
</style>

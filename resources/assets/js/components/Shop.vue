<template>
  <div>
    <div class="relative" style="height: 58vh">
      <div class="z-0 w-full h-full" style="background-image: url('/images/order_header.jpg'); background-size: cover; background-position: center"/>
      <div class="absolute pin-t z-0 bg-black opacity-25 w-full h-full"/>
    </div>
    <div class="relative font-main">
      <div class="absolute w-full -mt-120 flex justify-center">
        <div class="mx-3 sm:mx-0 max-w-xs sm:max-w-sm w-full">
          <h1 class="text-center text-grey-lightest font-title font-normal text-5xl mb-3" style="text-shadow: 2px 2px 3px black">Commande</h1>
          <div v-show="showAddressInput">
            <OrderAddressInput v-model="query" @change="value => addressUpdated(value)"/>
          </div>
          <div :class="showDatetimeInput ? '' : 'overflow-hidden'">
            <transition name="fade" enter-active-class="fadeInDown" leave-active-class="fadeOutUp">
              <div v-show="showDatetimeInput">
                <div v-show="!showAddressInput" class="bg-white px-4 pt-4 pb-3 shadow-lg rounded-t-lg z-10 flex">
                  <div class="w-full">
                    <div class="font-semibold text-grey-darkest text-sm mb-1">Adresse</div>
                    <div class="text-grey-darker text-sm">{{ orderAddress }}</div>
                  </div>
                  <button title="Modifier" class="ml-auto mb-auto text-orange-lighter hover:text-orange" @click="editAddress">
                    <i class="material-icons text-lg">edit</i>
                  </button>
                </div>
                <div :class="`bg-white px-4 pb-4 shadow-lg rounded-b-lg z-20 ${bottomClass} slide-transition`">
                  <div v-show="!deliveryTimeFilled">
                    <OrderTimeInput :disabled="showAddressInput" class="mb-3"/>
                    <ShopAlert/>
                  </div>
                  <transition name="fade">
                    <div v-show="deliveryTimeFilled" class="flex">
                      <div class="w-1/2">
                        <div class="font-semibold text-grey-darkest text-sm mb-1">Date</div>
                        <div class="text-grey-darker text-sm">{{ orderDate }}</div>
                      </div>
                      <div class="w-1/2 flex">
                        <div class="w-full">
                          <div class="font-semibold text-grey-darkest text-sm mb-1">Heure</div>
                          <div class="text-grey-darker text-sm">{{ orderTime }}</div>
                        </div>
                        <button title="Modifier" class="ml-auto mb-auto text-orange-lighter hover:text-orange" @click="editDatetime">
                          <i class="material-icons text-lg">edit</i>
                        </button>
                      </div>
                    </div>
                  </transition>
                </div>
              </div>
            </transition>
          </div>
        </div>
      </div>
      <div class="h-64">
        Yo
      </div>
    </div>
  </div>
</template>

<script>
import OrderAddressInput from './OrderAddressInput'
import OrderTimeInput from './OrderTimeInput'
import ShopAlert from './ShopAlert'
import { mapState, mapGetters } from 'vuex'
import _ from 'lodash'

export default {
  components: {
    OrderAddressInput,
    OrderTimeInput,
    ShopAlert
  },

  data () {
    return {
      query: '',
      showAddressInput: true,
      showDatetimeInput: false
    }
  },

  computed: {
    bottomClass () {
      return this.showAddressInput ? 'rounded-t-lg mt-10 pt-4 opacity-25' : ''
    },
    ...mapState('order', {
      orderTime: 'time',
      deliveryTimeFilled: 'deliveryTimeFilled'
    }),
    ...mapGetters({
      orderAddress: 'order/address',
      orderDate: 'order/date'
    })
  },

  methods: {
    addressUpdated (value) {
      if (value !== null && !_.isEmpty(this.$store.state.order.address)) {
        this.showAddressInput = false
        this.showDatetimeInput = true
      }
    },
    editAddress () {
      this.query = this.$store.state.order.address.query
      this.showAddressInput = true
    },
    editDatetime () {
      this.$store.commit('order/setDeliveryTimeFilled', false)
      this.showDatetimeInput = true
    }
  }
}
</script>

<style lang="scss">

.slide-transition {
  transition: padding 0.8s ease,
              opacity 0.25s ease,
              height 0.8s ease;
}
</style>

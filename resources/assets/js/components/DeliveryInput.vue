<template>
  <div>
    <div v-show="showAddressInput">
      <OrderAddressInput v-model="query" @change="value => addressUpdated(value)"/>
    </div>
    <div :class="showDateTimeInput ? '' : 'overflow-hidden'">
      <transition name="fade" enter-active-class="fadeInDown" leave-active-class="fadeOutUp">
        <div v-show="showDateTimeInput">
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
              <OrderDateTimeInput :disabled="showAddressInput" class="mb-3"/>
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
</template>

<script>
import { mapState, mapGetters } from 'vuex'
import _ from 'lodash'

import OrderAddressInput from './OrderAddressInput'
import OrderDateTimeInput from './OrderDateTimeInput'
import ShopAlert from './ShopAlert'

export default {
  components: {
    OrderAddressInput,
    OrderDateTimeInput,
    ShopAlert
  },

  props: {

  },

  data () {
    return {
      query: '',
      showAddressInput: true,
      showDateTimeInput: false
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
        this.showDateTimeInput = true
      }
    },
    editAddress () {
      this.query = this.$store.state.order.address.query
      this.showAddressInput = true
    },
    editDatetime () {
      this.$store.commit('order/setDeliveryTimeFilled', false)
      this.showDateTimeInput = true
    }
  }
}
</script>

<style lang="scss" scoped>
.slide-transition {
  transition: padding 0.8s ease,
              opacity 0.25s ease,
              height 0.8s ease;
}
</style>

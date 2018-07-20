<template>
  <div>
    <div v-show="showAddressInput">
      <OrderAddressInput v-model="query" @change="value => addressUpdated(value)"/>
    </div>
    <div :class="transitionWrapperClass">
      <transition enter-active-class="fadeInDown" leave-active-class="fadeOutUp">
        <SplittableCard v-show="showDateTimeInput" :split="showAddressInput">
          <div slot="top" class="flex">
            <div class="w-full">
              <div class="font-semibold text-grey-darkest text-sm mb-1">Adresse</div>
              <div class="text-grey-darker text-sm">{{ orderAddress }}</div>
            </div>
            <button title="Modifier" class="ml-auto mb-auto text-orange-lighter hover:text-orange" @click="editAddress">
              <i class="material-icons text-lg">edit</i>
            </button>
          </div>
          <div slot="bottom">
            <div v-show="!dateTimeFilled">
              <OrderDateTimeInput :disabled="showAddressInput" class="mb-3"/>
              <ShopAlert/>
            </div>
            <transition enter-active-class="fadeIn" leave-active-class="">
              <div v-show="dateTimeFilled" class="flex">
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
        </SplittableCard>
      </transition>
    </div>
  </div>
</template>

<script>
import { mapState, mapGetters } from 'vuex'
import _ from 'lodash'

import SplittableCard from './SplittableCard'
import OrderAddressInput from './OrderAddressInput'
import OrderDateTimeInput from './OrderDateTimeInput'
import ShopAlert from './ShopAlert'

export default {
  components: {
    SplittableCard,
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
    ...mapState('order', {
      orderTime: 'time',
      dateTimeFilled: 'dateTimeFilled'
    }),
    ...mapGetters({
      orderAddress: 'order/address',
      orderDate: 'order/date'
    }),
    transitionWrapperClass () {
      return this.showDateTimeInput ? '' : 'overflow-hidden'
    }
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
      this.$store.commit('order/setDeliveryInputFilled', false)
      this.showDateTimeInput = true
    }
  }
}
</script>

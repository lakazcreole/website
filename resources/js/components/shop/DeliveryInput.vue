<template>
  <div>
    <div v-show="showAddressInput">
      <AddressInput v-model="query" @change="value => addressUpdated(value)"/>
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
              <DateTimeInput :disabled="showAddressInput" class="mb-3" @filled="checkFilled"/>
              <Alert color="green">
                <p>Chaque commande est préparée par mes soins de l'achat des marchandises à la livraison chez vous. C'est pour cela qu'il n'est pas <em class="italic">encore</em> possible de commander pour le jour même.</p>
              </Alert>
            </div>
            <transition enter-active-class="fadeIn" leave-active-class="">
              <div v-show="dateTimeFilled" class="flex">
                <div class="w-1/2 mr-2">
                  <div class="font-semibold text-grey-darkest text-sm mb-1">Date</div>
                  <div class="text-grey-darker text-sm">{{ orderDate }}</div>
                </div>
                <div class="w-1/2 flex ml-2">
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

import Alert from '../Alert'

import SplittableCard from '../SplittableCard'
import AddressInput from './AddressInput'
import DateTimeInput from './DateTimeInput'

export default {
  components: {
    Alert,
    SplittableCard,
    AddressInput,
    DateTimeInput
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
        this.checkFilled()
        this.$emit('editedAddress')
      }
    },
    editAddress () {
      this.query = this.$store.state.order.address.query
      this.showAddressInput = true
      this.$store.commit('order/setAddress', {})
      this.$emit('editingAddress')
    },
    editDatetime () {
      this.$store.commit('order/setDateTimeFilled', false)
      this.showDateTimeInput = true
    },
    checkFilled () {
      if (this.orderAddress && this.dateTimeFilled) {
        this.$emit('filled')
      }
    }
  }
}
</script>

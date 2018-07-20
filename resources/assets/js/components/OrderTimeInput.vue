<template>
  <div class="flex items-baseline">
    <div class="w-1/2 mr-2">
      <label for="inputDate" class="block font-semibold text-grey-darkest text-sm mb-1">Date</label>
      <DatePicker
        id="inputDate"
        v-model="date"
        :disabled="disabled"
        :full-month-name="true"
        :monday-first="true"
        :disabled-dates="disabledDates"
        :highlighted="highlightedDates"
        :bootstrap-styling="false"
        :language="language"
        input-class="w-full p-2 h-10 rounded border border-grey-light text-grey-darkest"
        placeholder="Choisir une date"
      />
    </div>
    <div class="w-1/2 ml-2">
      <label for="inputTime" class="block font-semibold text-grey-darkest text-sm mb-1">Heure</label>
      <select v-model="time" :disabled="disabled" :class="`w-full p-2 h-10 bg-transparent rounded border border-grey-light ${selectClass}`">
        <option v-if="time === null" :value="null" class="text-grey-darkest">Choisir un horaire</option>
        <optgroup label="Midi" class="text-grey-darkest mt-3 mb-2">
          <option v-for="(hour, index) in deliveryHours.morning" :value="hour" :key="index" class="mb-1">{{ hour }}</option>
        </optgroup>
        <optgroup label="Soir" class="text-grey-darkest mt-3 mb-2">
          <option v-for="(hour, index) in deliveryHours.evening" :value="hour" :key="index" class="mb-1">{{ hour }}</option>
        </optgroup>
      </select>
    </div>
  </div>
</template>

<script>
import DatePicker from 'vuejs-datepicker'
import { fr } from 'vuejs-datepicker/dist/locale'
import { mapState } from 'vuex'

export default {
  components: {
    DatePicker
  },

  props: {
    disabled: {
      type: Boolean,
      default: false
    }
  },

  data () {
    return {
      disabledDates: {
        to: new Date()
      },
      highlightedDates: {
        dates: [
          new Date()
        ],
        includeDisabled: true
      },
      language: fr
    }
  },

  computed: {
    date: {
      get () {
        return this.$store.state.order.date
      },
      set (value) {
        this.$store.commit('order/setDate', value)
        this.$store.commit('order/setDeliveryTimeFilled', this.date !== null && this.time !== null)
      }
    },
    time: {
      get () {
        return this.$store.state.order.time
      },
      set (value) {
        this.$store.commit('order/setTime', value)
        this.$store.commit('order/setDeliveryTimeFilled', this.date !== null && this.time !== null)
      }
    },
    ...mapState('order', [
      'deliveryHours'
    ]),
    selectClass () {
      return this.time === null ? 'text-grey-dark' : ''
    }
  }
}
</script>

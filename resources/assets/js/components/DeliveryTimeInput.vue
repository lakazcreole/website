<template>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputDate" class="sr-only">Date</label>
      <DatePicker
        id="inputDate"
        :value="date"
        :full-month-name="true"
        :monday-first="true"
        :disabled="disabledDates"
        :highlighted="highlightedDates"
        :bootstrap-styling="true"
        language="fr"
        input-class="datepicker-bg"
        placeholder="Choisir une date"
        @input="onDateInput"
      />
    </div>
    <div class="form-group col-md-6">
      <label for="inputTime" class="sr-only">Heure</label>
      <select :value="time" class="custom-select" @change="e => onTimeChange(e.target.value)">
        <option v-if="time === null" :value="null" >Choisir un horaire</option>
        <optgroup label="Midi">
          <option v-for="(hour, index) in deliveryHours.morning" :value="hour" :key="index">{{ hour }}</option>
        </optgroup>
        <optgroup label="Soir">
          <option v-for="(hour, index) in deliveryHours.evening" :value="hour" :key="index">{{ hour }}</option>
        </optgroup>
      </select>
    </div>
  </div>
</template>

<script>
import DatePicker from 'vuejs-datepicker'
import { mapState } from 'vuex'

export default {
  components: {
    DatePicker
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
      }
    }
  },

  computed: {
    ...mapState('order', [
      'date',
      'time',
      'deliveryHours'
    ])
  },

  methods: {
    onDateInput (value) {
      this.$store.commit('order/setDate', value)
    },
    onTimeChange (value) {
      this.$store.commit('order/setTime', value)
    }
  }
}
</script>

<style type="scss">
  .datepicker-bg {
    background-color: white !important;
  }
</style>

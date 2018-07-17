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
      <select :value="time" class="custom-select" @input="e => onTimeInput(e.target.value)">
        <option v-if="time === null" :value="null" >Choisir un horaire</option>
        <optgroup label="Midi">
          <option value="11:30">11:30</option>
          <option value="11:45">11:45</option>
          <option value="12:00">12:00</option>
          <option value="12:15">12:15</option>
          <option value="12:30">12:30</option>
          <option value="12:45">12:45</option>
          <option value="13:00">13:00</option>
        </optgroup>
        <optgroup label="Soir">
          <option value="19:45">19:45</option>
          <option value="20:00">20:00</option>
          <option value="20:15">20:15</option>
          <option value="20:30">20:30</option>
          <option value="20:45">20:45</option>
          <option value="21:00">21:00</option>
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
      'time'
    ])
  },

  methods: {
    onDateInput (value) {
      this.$store.commit('order/setDate', value)
    },
    onTimeInput (value) {
      console.log('time', value)
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

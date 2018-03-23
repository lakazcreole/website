<script>
import DatePicker from 'vuejs-datepicker'

export default {
  props: {
    defaultDate: {
      type: Date,
      required: false,
      default: null
    },
    defaultTime: {
      type: String,
      required: false,
      default: null
    },
    onDateInput: {
      type: Function,
      required: false
    },
    onTimeInput: {
      type: Function,
      required: false
    }
  },
  components: {
    DatePicker
  },
}
</script>

<template>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputDate" class="sr-only">Date</label>
      <DatePicker :value="defaultDate" v-on:input="value => { onDateInput(value) }"
        language="fr" :full-month-name="true" :bootstrap-styling="true" input-class="datepicker-bg"
        id="inputDate" placeholder="Choisir une date">
      </DatePicker>
    </div>
    <div class="form-group col-md-6">
      <label for="inputTime" class="sr-only">Heure</label>
      <select :value="defaultTime" v-on:input="event => { onTimeInput(event.target.value) }" class="custom-select">
        <option v-if="defaultTime === null" :value="null" >Choisir un horaire</option>
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
          <option value="19:00">19:00</option>
          <option value="19:15">19:15</option>
          <option value="19:30">19:30</option>
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

<style type="scss">
  .datepicker-bg {
    background-color: white !important
  }
</style>

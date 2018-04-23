<template>
  <div>
    <div class="d-flex">
      {{ name }}
      <div class="ml-auto ">
        <div class="form-check form-check-inline">
          <input v-model="disabled" type="checkbox" id="checkbox" :disabled="waiting" @change="updateDisabled">
          <label class="form-check-label" for="checkbox">
            <small>Indisponible</small>
          </label>
        </div>
        <a :href="`/dashboard/products/${id}/edit`" class="btn btn-outline-secondary btn-sm">Modifier</a>
      </div>
    </div>
    <div v-if="errors && errors.errors['disabled']" class="d-flex invalid-feedback">
      <span v-for="(err, index) in errors.errors['disabled']" :key="index">{{ err }} </span>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  props: {
    id: {
      type: Number,
      required: true
    },
    name: {
      type: String,
      required: true
    },
    initialDisabled: {
      type: Boolean,
      required: true
    },
    apiToken: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      disabled: null,
      waiting: false,
      errors: null
    }
  },
  mounted() {
    this.disabled = this.disabled
  },
  methods: {
    updateDisabled() {
      // eslint-disable-next-line no-console
      console.log(`put: /api/products/${this.id}`)
      this.waiting = true
      axios.put(`/api/products/${this.id}`, {
        disabled: this.disabled
      },{
        headers: {
          'Authorization': `Bearer ${this.apiToken}`
        }
      })
      .then(response => {
        // eslint-disable-next-line no-console
        console.log(response)
        this.waiting = false
      })
      .catch(error => {
        this.waiting = false
        // eslint-disable-next-line no-console
        console.log(error)
        if (error.response && error.response.status === 422) {
            this.errors = error.response.data
        } else {
            this.$emit('serverError')
        }
      })
    }
  }
}
</script>

<template>
  <div>
    <div class="d-flex">
      {{ name }}
      <div class="ml-auto ">
        <div class="form-check form-check-inline">
          <input v-model="state" class="form-check-input" type="checkbox" id="checkbox" @change="updateDisabled" :disabled="waiting">
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
    disabled: {
      type: Boolean,
      required: true
    },
    apiToken: {
      type: String,
      require: true
    }
  },
  data() {
    return {
      state: null,
      waiting: false,
      errors: null
    }
  },
  mounted() {
    this.state = this.disabled
  },
  methods: {
    updateDisabled() {
      this.waiting = true
      axios.put(`/api/products/${this.id}`, {
        disabled: this.state
      },{
        headers: {
          'Authorization': `Bearer ${this.apiToken}`
        }
      })
      .then(response => {
        this.waiting = false
      })
      .catch(error => {
        this.waiting = false
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

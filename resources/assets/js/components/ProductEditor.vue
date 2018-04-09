<template>
  <div class="d-flex">
    {{ name }}
    <!-- <div class="ml-auto form-check form-check-inline">
      <input v-model="state" class="form-check-input" type="checkbox" id="checkbox" @change="updateDisabled" :disabled="waiting">
      <label class="form-check-label" for="checkbox">
        Désactivé
      </label>
    </div> -->
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
    }
  },
  data() {
    return {
      state: null,
      waiting: false,
      errors: []
    }
  },
  mounted() {
    this.state = this.disabled
  },
  methods: {
    updateDisabled() {
      this.waiting = true
      axios.put(`/api/products/${this.id}`, {
        headers: {
          'HTTP_Authorization': 'Bearer' + 'api_token'
        },
        data:{
          disabled: this.state
        }
      })
      .then(response => {
        this.waiting = false
        console.log("ok")
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

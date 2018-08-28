<template>
  <button class="text-grey-dark no-underline" @click="showContactModal">
    Contact
  </button>
</template>

<script>
import ContactModal from './ContactModal'

export default {
  components: {
    ContactModal
  },

  methods: {
    showContactModal () {
      this.$modal.show('contact-modal')
    }
  }
}
</script>

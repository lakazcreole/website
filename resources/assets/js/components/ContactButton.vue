<template>
  <a class="nav-link" href="#" @click.prevent="showContactModal">
    Contact
  </a>
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

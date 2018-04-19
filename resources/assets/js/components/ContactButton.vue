<template>
  <a class="nav-link" href="#" @click.prevent="showContactModal = true">
    Contact
    <portal v-if="showContactModal" to="modal">
      <contact-modal @close="showContactModal = false"/>
    </portal>
  </a>
</template>

<script>
import ContactModal from './ContactModal'

export default {
  components: {
    ContactModal
  },

  data() {
    return {
      showContactModal: false
    }
  }
}
</script>

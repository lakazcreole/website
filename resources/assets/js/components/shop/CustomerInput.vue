<template>
  <div>
    <h2 class="uppercase font-semibold text-grey text-base tracking-wide mb-5">Coordonnées</h2>
    <div class="bg-white shadow-lg rounded-lg p-4">
      <div class="flex mb-5">
        <div class="w-1/2 mr-2">
          <FormInput v-model="firstName" name="firstName" label="Prénom" placeholder="Dimitri"/>
        </div>
        <div class="w-1/2 ml-2">
          <FormInput v-model="lastName" name="lastName" label="Nom" placeholder="Payet"/>
        </div>
      </div>
      <div class="flex mb-5">
        <div class="w-1/2 mr-2">
          <FormInput v-model="email" name="email" type="email" label="E-mail" placeholder="dimitri974@email.fr"/>
        </div>
        <div class="w-1/2 ml-2">
          <FormInput v-model="phone" name="phone" type="phone" label="Téléphone" placeholder="06 ..."/>
        </div>
      </div>
      <FormInput v-model="informations" name="informations" label="Informations de livraison" placeholder="Code, interphone ou information utile"/>
    </div>
  </div>
</template>

<script>
import FormInput from '../FormInput'

export default {
  components: {
    FormInput
  },

  computed: {
    firstName: {
      get () {
        return this.$store.state.order.customer.firstName
      },
      set (value) {
        this.$store.commit('order/setCustomerFirstName', value)
      }
    },
    lastName: {
      get () {
        return this.$store.state.order.customer.lastName
      },
      set (value) {
        this.$store.commit('order/setCustomerLastName', value)
      }
    },
    email: {
      get () {
        return this.$store.state.order.customer.email
      },
      set (value) {
        this.$store.commit('order/setCustomerEmail', value)
      }
    },
    phone: {
      get () {
        return this.$store.state.order.customer.phone
      },
      set (value) {
        this.$store.commit('order/setCustomerPhone', value)
      }
    },
    informations: {
      get () {
        return this.$store.state.order.informations
      },
      set (value) {
        this.$store.commit('order/setInformations', value)
      }
    }
  }
}
</script>

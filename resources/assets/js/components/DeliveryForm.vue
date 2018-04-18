<script>
export default {
  props: {
    errors: {
      type: Object,
      required: false
    },
    onFirstNameInput: {
      type: Function,
      required: true
    },
    onLastNameInput: {
      type: Function,
      required: true
    },
    onEmailInput: {
      type: Function,
      required: true
    },
    onPhoneInput: {
      type: Function,
      required: true
    },
    onAddressOneInput: {
      type: Function,
      required: true
    },
    onAddressTwoInput: {
      type: Function,
      required: true
    },
    onAddressThreeInput: {
      type: Function,
      required: true
    },
    onCityInput: {
      type: Function,
      required: true
    },
    onZipInput: {
      type: Function,
      required: true
    }
  }
}
</script>

<template>
  <div>
    <h2>Livraison</h2>
    <!-- <form> -->
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="inputFirstName">Prénom</label>
          <input @input="e => { onFirstNameInput(e.target.value) }" type="text" class="form-control" id="inputFirstName" placeholder="Prénom" autocomplete="given-name">
          <div v-if="errors && errors.errors['customer.firstName']" class="d-flex invalid-feedback">
            <span v-for="(err, index) in errors.errors['customer.firstName']" :key="index">{{ err }} </span>
          </div>
        </div>
        <div class="form-group col-md-6">
          <label for="inputLastName">Nom</label>
          <input @input="e => { onLastNameInput(e.target.value) }" type="text" class="form-control" id="inputLastName" placeholder="Nom" autocomplete="family-name">
          <div v-if="errors && errors.errors['customer.lastName']" class="d-flex invalid-feedback">
            <span v-for="(err, index) in errors.errors['customer.lastName']" :key="index">{{ err }} </span>
          </div>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="inputEmail">E-mail</label>
          <input @input="e => { onEmailInput(e.target.value) }" type="email" class="form-control" id="inputEmail" placeholder="E-mail" autocomplete="email">
          <div v-if="errors && errors.errors['customer.email']" class="d-flex invalid-feedback">
            <span v-for="(err, index) in errors.errors['customer.email']" :key="index">{{ err }} </span>
          </div>
        </div>
        <div class="form-group col-md-6">
          <label for="inputPhone">Téléphone</label>
          <input @input="e => { onPhoneInput(e.target.value) }" type="phone" class="form-control" id="inputPhone" placeholder="Téléphone" autocomplete="tel-national">
          <div v-if="errors && errors.errors['customer.phone']" class="d-flex invalid-feedback">
            <span v-for="(err, index) in errors.errors['customer.phone']" :key="index">{{ err }} </span>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label for="inputAddress1">Adresse</label>
        <input @input="e => { onAddressOneInput(e.target.value) }" type="text" class="form-control" id="inputAddress1" placeholder="Numéro et voie" autocomplete="address-line1">
          <div v-if="errors && errors.errors['address.address1']" class="d-flex invalid-feedback">
            <span v-for="(err, index) in errors.errors['address.address1']" :key="index">{{ err }} </span>
          </div>
      </div>
      <div class="form-group">
        <label for="inputAddress2">Adresse 2</label>
        <input @input="e => { onAddressTwoInput(e.target.value) }" type="text" class="form-control" id="inputAddress2" placeholder="Bâtiment, appartement ou étage" autocomplete="address-line2">
          <div v-if="errors && errors.errors['address.address2']" class="d-flex invalid-feedback">
            <span v-for="(err, index) in errors.errors['address.address2']" :key="index">{{ err }} </span>
          </div>
      </div>
      <div class="form-group">
        <label for="inputAddress3">Instructions de livraison</label>
        <input @input="e => { onAddressThreeInput(e.target.value) }" type="text" class="form-control" id="inputAddress3" placeholder="Code, interphone ou information utile" autocomplete="address-line3">
          <div v-if="errors && errors.errors['address.address3']" class="d-flex invalid-feedback">
            <span v-for="(err, index) in errors.errors['address.address3']" :key="index">{{ err }} </span>
          </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-8">
          <label for="inputCity">Ville</label>
          <input @input="e => { onCityInput(e.target.value) }" type="text" class="form-control" id="inputCity" placeholder="Ville" autocomplete="address-level1">
          <div v-if="errors && errors.errors['address.city']" class="d-flex invalid-feedback">
            <span v-for="(err, index) in errors.errors['address.city']" :key="index">{{ err }} </span>
          </div>
        </div>
        <div class="form-group col-md-4">
          <label for="inputZip">Code postal</label>
          <input @input="e => { onZipInput(e.target.value) }" type="text" class="form-control" id="inputZip" placeholder="Code postal" autocomplete="postal-code">
          <div v-if="errors && errors.errors['address.zip']" class="d-flex invalid-feedback">
            <span v-for="(err, index) in errors.errors['address.zip']" :key="index">{{ err }} </span>
          </div>
        </div>
      </div>
    <!-- </form> -->
  </div>
</template>

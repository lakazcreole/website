
<template>
  <div>
    <h2>Livraison</h2>
    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="inputFirstName">Prénom</label>
        <input id="inputFirstName" type="text" class="form-control" placeholder="Prénom" autocomplete="given-name" @input="e => { onFirstNameInput(e.target.value) }">
        <div v-if="errors && errors.errors['customer.firstName']" class="d-flex invalid-feedback">
          <span v-for="(err, index) in errors.errors['customer.firstName']" :key="index">{{ err }} </span>
        </div>
      </div>
      <div class="form-group col-md-6">
        <label for="inputLastName">Nom</label>
        <input id="inputLastName" type="text" class="form-control" placeholder="Nom" autocomplete="family-name" @input="e => { onLastNameInput(e.target.value) }">
        <div v-if="errors && errors.errors['customer.lastName']" class="d-flex invalid-feedback">
          <span v-for="(err, index) in errors.errors['customer.lastName']" :key="index">{{ err }} </span>
        </div>
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="inputEmail">E-mail</label>
        <input id="inputEmail" type="email" class="form-control" placeholder="E-mail" autocomplete="email" @input="e => { onEmailInput(e.target.value) }">
        <div v-if="errors && errors.errors['customer.email']" class="d-flex invalid-feedback">
          <span v-for="(err, index) in errors.errors['customer.email']" :key="index">{{ err }} </span>
        </div>
      </div>
      <div class="form-group col-md-6">
        <label for="inputPhone">Téléphone</label>
        <input id="inputPhone" type="phone" class="form-control" placeholder="Téléphone" autocomplete="tel-national" @input="e => { onPhoneInput(e.target.value) }">
        <div v-if="errors && errors.errors['customer.phone']" class="d-flex invalid-feedback">
          <span v-for="(err, index) in errors.errors['customer.phone']" :key="index">{{ err }} </span>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label for="inputAddress1">Adresse</label>
      <input id="inputAddress1" type="text" class="form-control" placeholder="Numéro et voie" autocomplete="address-line1" @input="e => { onAddressOneInput(e.target.value) }">
      <div v-if="errors && errors.errors['address.address1']" class="d-flex invalid-feedback">
        <span v-for="(err, index) in errors.errors['address.address1']" :key="index">{{ err }} </span>
      </div>
    </div>
    <div class="form-group">
      <label for="inputAddress2">Adresse 2</label>
      <input id="inputAddress2" type="text" class="form-control" placeholder="Bâtiment, appartement ou étage" autocomplete="address-line2" @input="e => { onAddressTwoInput(e.target.value) }">
      <div v-if="errors && errors.errors['address.address2']" class="d-flex invalid-feedback">
        <span v-for="(err, index) in errors.errors['address.address2']" :key="index">{{ err }} </span>
      </div>
    </div>
    <div class="form-group">
      <label for="inputAddress3">Instructions de livraison</label>
      <input id="inputAddress3" type="text" class="form-control" placeholder="Code, interphone ou information utile" autocomplete="address-line3" @input="e => { onAddressThreeInput(e.target.value) }">
      <div v-if="errors && errors.errors['address.address3']" class="d-flex invalid-feedback">
        <span v-for="(err, index) in errors.errors['address.address3']" :key="index">{{ err }} </span>
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-8">
        <label for="inputCity">Ville</label>
        <input id="inputCity" type="text" class="form-control" placeholder="Ville" autocomplete="address-level1" @input="e => { onCityInput(e.target.value) }">
        <div v-if="errors && errors.errors['address.city']" class="d-flex invalid-feedback">
          <span v-for="(err, index) in errors.errors['address.city']" :key="index">{{ err }} </span>
        </div>
      </div>
      <div class="form-group col-md-4">
        <label for="inputZip">Code postal</label>
        <input id="inputZip" type="text" class="form-control" placeholder="Code postal" autocomplete="postal-code" @input="e => { onZipInput(e.target.value) }">
        <div v-if="errors && errors.errors['address.zip']" class="d-flex invalid-feedback">
          <span v-for="(err, index) in errors.errors['address.zip']" :key="index">{{ err }} </span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    errors: {
      type: Object,
      required: false,
      default: null
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

<script>
export default {
  data() {
    return {
      firstName: '',
      lastName: '',
      email: '',
      phone: '',
      address1: '',
      address2: '',
      address3: '',
      city: '',
      zip: ''
    }
  }
}
</script>

<template>
  <div>
    <h2>Livraison</h2>
    <form>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="inputFirstName">Prénom</label>
          <input v-model="firstName" type="text" class="form-control" id="inputFirstName" placeholder="Prénom" autocomplete="given-name">
        </div>
        <div class="form-group col-md-6">
          <label for="inputLastName">Nom</label>
          <input v-model="lastName" type="text" class="form-control" id="inputLastName" placeholder="Nom" autocomplete="family-name">
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="inputEmail">E-mail</label>
          <input v-model="email" type="email" class="form-control" id="inputEmail" placeholder="E-mail" autocomplete="email">
        </div>
        <div class="form-group col-md-6">
          <label for="inputPhone">Téléphone</label>
          <input v-model="phone" type="phone" class="form-control" id="inputPhone" placeholder="Téléphone" autocomplete="tel-national">
        </div>
      </div>
      <div class="form-group">
        <label for="inputAddress">Adresse</label>
        <input v-model="address1" type="text" class="form-control" id="inputAddress" placeholder="Numéro et voie" autocomplete="address-line1">
      </div>
      <div class="form-group">
        <label for="inputAddress2">Adresse 2</label>
        <input v-model="address2" type="text" class="form-control" id="inputAddress2" placeholder="Bâtiment, appartement ou étage" autocomplete="address-line2">
      </div>
      <div class="form-group">
        <label for="inputAddress3">Instructions de livraison</label>
        <input v-model="address3" type="text" class="form-control" id="inputAddress3" placeholder="Code, interphone ou information utile" autocomplete="address-line3">
      </div>
      <div class="form-row">
        <div class="form-group col-md-8">
          <label for="inputCity">Ville</label>
          <input v-model="city" type="text" class="form-control" id="inputCity" placeholder="Ville" autocomplete="address-level1">
        </div>
        <div class="form-group col-md-4">
          <label for="inputZip">Code postal</label>
          <input v-model="zip" type="text" class="form-control" id="inputZip" placeholder="Code postal" autocomplete="postal-code">
        </div>
      </div>
    </form>
  </div>
</template>

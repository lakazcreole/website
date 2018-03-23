<script>
    export default {
        data() {
            return {
                email: '',
                errors: null,
                subscribed: false,
                serverError: false
            }
        },
        computed: {
            inputClasses() {
                if (this.errors && this.errors.errors.hasOwnProperty('email')) return 'form-control is-invalid'
                return 'form-control'
            }
        },
        methods: {
            onSubmit() {
                axios.post('/api/subscriptions', {
                    email: this.email
                }).then(response => {
                    this.subscribed = true
                }).catch(error => {
                    if (error.response && error.response.status === 422) {
                        this.errors = error.response.data
                    } else {
                        this.serverError = true
                    }
                })
            }
        }
    }
</script>

<template>
    <div class="newsletter">
        <p v-if="serverError" class="text-center text-light">Une erreur s'est produite. Veuillez réessayer plus tard.</p>
        <div v-else >
            <p v-if="subscribed" class="text-center text-light">Vous êtes maintenant abonné à notre newsletter. Merci !</p>
            <div v-else>
                <p class="text-center text-light">
                    Pour suivre le projet et recevoir nos actualités, inscrivez-vous à la newsletter !
                </p>
                <div class="d-flex">
                    <form v-on:submit.prevent="onSubmit" class="form-inline mx-auto d-flex align-items-start justify-content-center">
                        <div class="m-2">
                            <input v-model="email" type="email" :class="inputClasses" id="email" placeholder="Entrez votre email"/>
                            <div v-if="errors" class="d-flex invalid-feedback">
                                <span v-for="err in errors.errors.email">{{ err }} </span>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary m-2">Inscription</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

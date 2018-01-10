<template>
    <div>
        <p class="text-center">Pour suivre le projet et recevoir les nouveautés inscrivez-vous à la newsletter !</p>
        <form v-on:submit.prevent="onSubmit">
            <label for="name">Nom :</label>
            <input v-model="name" type="text" id="name"/>
            <label for="email">E-mail :</label>
            <input v-model="email" type="email" id="email" />
            <label for="subject">Objet :</label>
            <input v-model="subject" type="text" id="subject"/>
            <label for="message">Message :</label>
            <textarea v-model="message" placeholder="Entrez votre message..." id="message"></textarea>
            <button type="submit">Envoyer</button>
        </form>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                name: '',
                email: '',
                subject: '',
                message: ''
            }
        },

        methods: {
            onSubmit: function() {
                this.$http.post('/api/contact', {
                    name: this.name,
                    email: this.email,
                    subject: this.subject,
                    message: this.message
                }).then(function() {
                    console.log("ok")
                }, function() {
                    console.log("nok")
                })
            }
        }
    }
</script>

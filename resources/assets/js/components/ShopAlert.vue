<template>
  <div class="border-l-4 border-green bg-green-lightest px-4 py-2 leading-normal text-green-darkest text-sm text-justify">
    <p class="mb-1">
      Chaque commande est préparée par mes soins de l'achat des marchandises à la livraison chez vous. Il faut donc commander <strong class="text-green-darkest">24h à l'avance</strong> pour que je puisse vous servir dans les meilleures conditions. Merci d'avance pour votre compréhension.
    </p>
    <p>Pour toute demande particulière, <button class="text-green-darkest font-bold no-underline" @click.prevent="$modal.show('contact-modal')">contactez-moi directement</button> !</p>
  </div>
</template>

<script>
export default {
  props: {

  },
  data () {
    return {

    }
  }
}
</script>

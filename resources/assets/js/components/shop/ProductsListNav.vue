<template>
  <div class="text-right mx-3 px-4 text-sm uppercase font-semibold tracking-wide text-grey">
    <scrollactive :offset="250" active-class="text-orange-light">
      <a v-for="type in types" :href="`#${type.key}`" :class="`block text-grey no-underline scrollactive-item mb-5`" :key="type.key">
        {{ type.name }}
      </a>
    </scrollactive>
  </div>

</template>

<script>
import { mapState } from 'vuex'

export default {
  props: {

  },
  data () {
    return {

    }
  },

  computed: {
    ...mapState('products', [
      'types'
    ]),
    currentCategory () {
      return this.$store.state.products.currentCategory
    }
  },

  methods: {
    categoryClass (typeName) {
      return this.currentCategory === typeName ? 'text-orange-light' : ''
    }
  }
}
</script>

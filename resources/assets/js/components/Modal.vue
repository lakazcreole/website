<template>
  <transition name="modal">
    <div class="modal-mask">
      <div class="modal-wrapper">
        <div class="modal-container" v-click-outside="onClickOutside">
          <div class="card">
            <div class="card-header py-3 d-flex">
              <slot name="header">header</slot>
              <button type="button" class="close ml-auto mb-auto" @click="$emit('close')">&times;</button>
            </div>
            <div class="card-body">
              <slot name="body">body</slot>
            </div>
            <div class="card-footer py-3">
              <slot name="footer">
                footer
                <button class="modal-default-button" @click="$emit('close')">OK</button>
              </slot>
            </div>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
export default {
  methods: {
    onClickOutside: function() {
      this.$emit('close')
    }
  },
  directives: {
    'click-outside': {
      bind: function(el, binding, vNode) {
        // Provided expression must evaluate to a function.
        if (typeof binding.value !== 'function') {
          const compName = vNode.context.name
          let warn = `[Vue-click-outside:] provided expression '${binding.expression}' is not a function, but has to be`
          if (compName) { warn += `Found in component '${compName}'` }

          console.warn(warn) // eslint-disable-line no-console
      }
      // Define Handler and cache it on the element
      const bubble = binding.modifiers.bubble
      const handler = (e) => {
      if (bubble || (!el.contains(e.target) && el !== e.target)) {
      binding.value(e)
      }
      }
      el.__vueClickOutside__ = handler

      // add Event Listeners
      document.addEventListener('click', handler)
    },

    // eslint-disable-next-line no-unused-vars
    unbind: function(el, binding) {
      // Remove Event Listeners
      document.removeEventListener('click', el.__vueClickOutside__)
      el.__vueClickOutside__ = null
      }
    }
  }
}
</script>

<style scoped>
  .modal-mask {
    position: fixed;
    z-index: 9998;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, .5);
    display: table;
    transition: opacity .3s ease;
  }

  .modal-wrapper {
    display: table-cell;
    vertical-align: middle;
  }

  .modal-container {
    max-width: 500px;
    margin: 0px auto;
    transition: all .3s ease;
  }
</style>

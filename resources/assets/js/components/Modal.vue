<template>
  <vue-modal
    :name="name"
    :scrollable="true"
    :adaptive="true"
    height="auto"
    transition="modal"
  >
    <div class="card">
      <div class="card-header py-3 d-flex">
        <slot name="header">
          Header
        </slot>
        <button type="button" class="close ml-auto mb-auto" @click="hide">&times;</button>
      </div>
      <div class="card-body">
        <slot name="body">
          Body
        </slot>
      </div>
      <div class="card-footer">
        <slot name="footer">
          Footer
        </slot>
      </div>
    </div>
  </vue-modal>
</template>

<script>
export default {
  props: {
    name: {
      type: String,
      required: true
    }
  },
  methods: {
    show () {
      this.$modal.show(this.name)
    },
    hide () {
      this.$modal.hide(this.name)
    }
  }
}
</script>

<style lang="scss">
.v--modal-overlay {
  z-index: 1050;

}
.v--modal-overlay .v--modal-box {
  overflow: visible;
}
</style>

export default {
  computed: {
    headerHeightClass () {
      if (this.showMenu) {
        // editing address
        if (this.editingAddress) return 'h-53vh lg:h-34vh'
        // editing datetime
        if (!this.deliveryInputFilled) return 'h-82vh sm:h-67vh lg:h-43vh'
        // not editing
        return 'h-34vh lg:h-20vh'
      }
      // Values when menu is not shown
      return this.deliveryInputFilled ? 'h-20vh' : 'h-82vh lg:h-67vh xl:h-58vh' // sm:h-70vh
    },
    headerMarginClass () {
      if (this.showMenu) {
        // editing address
        if (this.editingAddress) return '-mt-68'
        // editing datetime
        if (!this.deliveryInputFilled) return '-mt-108 sm:-mt-88 lg:-mt-92'
        // not editing
        return '-mt-40'
      }
      // Values when menu is not shown
      return this.deliveryInputFilled ? '-mt-40' : '-mt-112 sm:-mt-108 lg:-mt-104 xl:-mt-120'
    }
  }
}

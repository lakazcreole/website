<template>
  <div>
    <label :for="name" class="block font-semibold text-grey-darker text-sm mb-2">{{ label }}</label>
    <input
      :value="value"
      :type="type"
      :name="name"
      :placeholder="placeholder"
      class="w-full p-2 rounded border border-grey-light text-grey-darker"
      @input="$emit('input', $event.target.value)"
    >
    <div v-if="errors.length" class="mt-2 text-sm text-red-light">
      <div v-for="(error, index) in errors" :key="index">{{ error }}</div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    value: {
      type: String,
      default: ''
    },
    type: {
      type: String,
      default: 'text'
    },
    name: {
      type: String,
      required: true
    },
    label: {
      type: String,
      required: true
    },
    placeholder: {
      type: String,
      default: ''
    },
    errors: {
      type: Array,
      default: () => []
    }
  }
}
</script>

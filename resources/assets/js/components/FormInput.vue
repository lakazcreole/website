<template>
  <div>
    <label :for="`form-input-${name}`" class="block font-semibold text-grey-darker text-sm mb-2">{{ label }}</label>
    <textarea
      v-if="type === 'textarea'"
      :id="`form-input-${name}`"
      :value="value"
      :disabled="disabled"
      :placeholder="placeholder"
      :rows="rows"
      class="w-full p-2 rounded border border-grey-light text-grey-darker"
      @input="$emit('input', $event.target.value)"
    />
    <input
      v-else
      :id="`form-input-${name}`"
      :value="value"
      :type="type"
      :name="name"
      :disabled="disabled"
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
    rows: {
      type: Number,
      default: 3
    },
    disabled: {
      type: Boolean,
      default: false
    },
    errors: {
      type: Array,
      default: () => []
    }
  }
}
</script>

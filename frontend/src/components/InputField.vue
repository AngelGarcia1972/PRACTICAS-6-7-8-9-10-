<template>
  <div class="campo">
    <label :for="name">{{ label }}</label>
    <input
      :id="name"
      :name="name"
      :value="modelValue"
      :type="type"
      :class="{ error: error }"
      v-bind="$attrs"
      @input="$emit('update:modelValue', $event.target.value)"
    />
    <span class="error-msg" v-if="error">{{ error }}</span>
  </div>
</template>

<script setup>
defineProps({
  label:      { type: String, required: true },
  name:       { type: String, required: true },
  modelValue: { type: [String, Number], default: '' },
  error:      { type: String, default: '' },
  type:       { type: String, default: 'text' },
})
defineEmits(['update:modelValue'])
</script>

<style scoped>
.campo { display: flex; flex-direction: column; margin-bottom: 1rem; }
label { font-weight: bold; margin-bottom: 0.25rem; }
input { padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; }
input.error { border-color: red; }
.error-msg { color: red; font-size: 0.85rem; margin-top: 0.25rem; }
</style>
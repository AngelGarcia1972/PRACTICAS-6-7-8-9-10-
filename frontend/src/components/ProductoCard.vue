<template>
  <div class="producto-card">
    <h3>{{ producto.nombre }}</h3>
    <p>Precio: {{ producto.precio }}</p>
    <p>Stock: {{ producto.stock }}</p>
    <button data-test="btn-agregar" @click="$emit('agregar-carrito', producto)">
      Agregar al carrito
    </button>
  </div>
</template>

<script setup>
defineProps({
  producto: { type: Object, required: true }
})
defineEmits(['agregar-carrito'])
</script>
<template>
  <div class="paginacion" v-if="meta.last_page > 1">
    <button @click="$emit('cambio-pagina', 1)" :disabled="meta.current_page === 1">«</button>
    <button @click="$emit('cambio-pagina', meta.current_page - 1)" :disabled="meta.current_page === 1">‹</button>

    <span>Página {{ meta.current_page }} de {{ meta.last_page }} ({{ meta.total }} resultados)</span>

    <button @click="$emit('cambio-pagina', meta.current_page + 1)" :disabled="meta.current_page === meta.last_page">›</button>
    <button @click="$emit('cambio-pagina', meta.last_page)" :disabled="meta.current_page === meta.last_page">»</button>
  </div>
</template>

<script setup>
defineProps({ meta: { type: Object, default: () => ({}) } });
defineEmits(["cambio-pagina"]);
</script>

<style scoped>
.paginacion { display: flex; align-items: center; gap: 0.5rem; margin-top: 1.5rem; flex-wrap: wrap; }
button { padding: 0.4rem 0.8rem; border: 1px solid #4f46e5; border-radius: 4px; background: white; color: #4f46e5; cursor: pointer; }
button:disabled { opacity: 0.4; cursor: not-allowed; }
span { font-size: 0.9rem; color: #555; }
</style>
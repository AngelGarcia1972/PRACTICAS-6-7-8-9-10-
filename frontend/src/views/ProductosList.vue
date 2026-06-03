<template>
  <div>
    <h2>Productos</h2>
    <div v-for="producto in productos" :key="producto.id">
      <ProductoCard :producto="producto" />
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import ProductoCard from '@/components/ProductoCard.vue'

const productos = ref([])

onMounted(async () => {
  const res = await axios.get('/api/productos')
  productos.value = res.data.data ?? res.data
})
</script>
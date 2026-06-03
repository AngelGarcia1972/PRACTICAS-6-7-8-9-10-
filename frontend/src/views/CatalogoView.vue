<script setup>
import { ref, watch } from "vue";
import { useRoute } from "vue-router";
import axios from "axios";
import { useFiltros } from "@/composables/useFiltros";
import ProductoCard from "@/components/ProductoCard.vue";
import PaginacionNav from "@/components/PaginacionNav.vue";
import FiltrosPanel from "@/components/FiltrosPanel.vue";

const route = useRoute();
const { filtros } = useFiltros();
const resultado = ref({ data: [], meta: {} });
const cargando = ref(false);

const cargarProductos = async () => {
	cargando.value = true;
	const { data } = await axios.get("http://localhost:8000/api/productos", {
		params: {
			busqueda: filtros.busqueda,
			categoria_id: filtros.categoria_id,
			precio_min: filtros.precio_min,
			precio_max: filtros.precio_max,
			page: filtros.pagina,
			orden: filtros.orden,
			dir: filtros.dir,
		},
	});
	resultado.value = data;
	cargando.value = false;
};

watch(() => route.query, cargarProductos, { immediate: true });
</script>

<template>
  <div class="catalogo">
    <h2>Catálogo de Productos</h2>

    <FiltrosPanel :filtros="filtros" />

    <p v-if="cargando">Cargando...</p>

    <div v-else class="productos-grid">
      <ProductoCard
        v-for="producto in resultado.data"
        :key="producto.id"
        :producto="producto"
      />
      <p v-if="resultado.data?.length === 0">No se encontraron productos.</p>
    </div>

    <PaginacionNav
      :meta="resultado.meta"
      @cambio-pagina="filtros.pagina = $event"
    />
  </div>
</template>

<style scoped>
.catalogo { max-width: 900px; margin: 2rem auto; padding: 1rem; }
h2 { margin-bottom: 1rem; }
.productos-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem; }
</style>
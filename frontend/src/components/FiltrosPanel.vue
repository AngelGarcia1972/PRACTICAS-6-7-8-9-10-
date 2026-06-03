<template>
  <div class="filtros-panel">
    <input
      v-model="busquedaLocal"
      type="text"
      placeholder="Buscar producto..."
    />

    <select v-model="filtros.categoria_id">
      <option value="">Todas las categorías</option>
      <option v-for="cat in categorias" :key="cat.id" :value="cat.id">
        {{ cat.nombre }}
      </option>
    </select>

    <input v-model="filtros.precio_min" type="number" placeholder="Precio mínimo" />
    <input v-model="filtros.precio_max" type="number" placeholder="Precio máximo" />

    <select v-model="filtros.orden">
      <option value="nombre">Nombre A-Z</option>
      <option value="precio">Precio menor</option>
    </select>

    <button @click="limpiar">Limpiar filtros</button>
  </div>
</template>

<script setup>
import { ref, watch, onMounted } from "vue";
import axios from "axios";

const props = defineProps({ filtros: { type: Object, required: true } });

const categorias = ref([]);
const busquedaLocal = ref(props.filtros.busqueda);

onMounted(async () => {
	const { data } = await axios.get("http://localhost:8000/api/categorias");
	categorias.value = data.data;
});

let timer;
watch(busquedaLocal, (val) => {
	clearTimeout(timer);
	timer = setTimeout(() => {
		props.filtros.busqueda = val;
	}, 300);
});

const limpiar = () => {
	busquedaLocal.value = "";
	props.filtros.busqueda = "";
	props.filtros.categoria_id = "";
	props.filtros.precio_min = "";
	props.filtros.precio_max = "";
	props.filtros.pagina = 1;
	props.filtros.orden = "nombre";
	props.filtros.dir = "asc";
};
</script>

<style scoped>
.filtros-panel { display: flex; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 1.5rem; }
input, select { padding: 0.4rem 0.6rem; border: 1px solid #ccc; border-radius: 4px; }
button { padding: 0.4rem 0.8rem; background: #ef4444; color: white; border: none; border-radius: 4px; cursor: pointer; }
</style>
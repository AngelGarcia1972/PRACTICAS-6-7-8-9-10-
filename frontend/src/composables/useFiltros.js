import { reactive, watch } from "vue";
import { useRoute, useRouter } from "vue-router";

export function useFiltros() {
	const route = useRoute();
	const router = useRouter();

	const filtros = reactive({
		busqueda: route.query.busqueda || "",
		categoria_id: route.query.categoria || "",
		precio_min: route.query.min || "",
		precio_max: route.query.max || "",
		pagina: Number(route.query.p) || 1,
		orden: route.query.orden || "nombre",
		dir: route.query.dir || "asc",
	});

	watch(filtros, () => {
		router.push({
			query: {
				busqueda: filtros.busqueda || undefined,
				categoria: filtros.categoria_id || undefined,
				min: filtros.precio_min || undefined,
				max: filtros.precio_max || undefined,
				p: filtros.pagina > 1 ? filtros.pagina : undefined,
				orden: filtros.orden !== "nombre" ? filtros.orden : undefined,
				dir: filtros.dir !== "asc" ? filtros.dir : undefined,
			},
		});
	});

	return { filtros };
}

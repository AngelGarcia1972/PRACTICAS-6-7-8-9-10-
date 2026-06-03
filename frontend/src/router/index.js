import { createRouter, createWebHistory } from "vue-router";
import ProductoForm from "@/views/ProductoForm.vue";
import CatalogoView from "@/views/CatalogoView.vue";
import LoginView from "@/views/LoginView.vue";

const router = createRouter({
	history: createWebHistory(import.meta.env.BASE_URL),
	routes: [
		{ path: "/", name: "home", component: ProductoForm },
		{ path: "/catalogo", name: "catalogo", component: CatalogoView },
		{ path: "/login", name: "login", component: LoginView },
	],
});

export default router;

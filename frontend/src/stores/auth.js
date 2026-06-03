import { defineStore } from "pinia";
import { ref } from "vue";
import axios from "axios";

export const useAuthStore = defineStore("auth", () => {
	const user = ref(null);
	const token = ref(localStorage.getItem("token") || null);
	const permisos = ref({ crear: false, editar: false, eliminar: false });

	axios.defaults.baseURL = "http://localhost:8000";

	if (token.value) {
		axios.defaults.headers.common["Authorization"] = `Bearer ${token.value}`;
	}

	async function login(email, password) {
		const { data } = await axios.post("/api/login", { email, password });
		token.value = data.token;
		user.value = data.user;
		localStorage.setItem("token", data.token);
		axios.defaults.headers.common["Authorization"] = `Bearer ${data.token}`;
		await fetchMe();
	}

	async function fetchMe() {
		const { data } = await axios.get("/api/me");
		user.value = data;
		permisos.value = data.permisos;
	}

	function logout() {
		user.value = null;
		token.value = null;
		permisos.value = { crear: false, editar: false, eliminar: false };
		localStorage.removeItem("token");
		delete axios.defaults.headers.common["Authorization"];
	}

	return { user, token, permisos, login, fetchMe, logout };
});

<template>
  <div class="login">
    <h2>Iniciar Sesión</h2>
    <form @submit.prevent="handleLogin">
      <input v-model="email"    type="email"    placeholder="Email" required />
      <input v-model="password" type="password" placeholder="Contraseña" required />
      <button type="submit">Entrar</button>
      <p v-if="error" class="error">{{ error }}</p>
    </form>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import { useAuthStore } from "@/stores/auth";

const auth = useAuthStore();
const router = useRouter();
const email = ref("");
const password = ref("");
const error = ref("");

const handleLogin = async () => {
	try {
		error.value = "";
		await auth.login(email.value, password.value);
		router.push("/catalogo");
	} catch (e) {
		error.value = "Credenciales incorrectas";
	}
};
</script>

<style scoped>
.login { max-width: 400px; margin: 4rem auto; padding: 2rem; border: 1px solid #ddd; border-radius: 8px; }
h2 { margin-bottom: 1rem; }
form { display: flex; flex-direction: column; gap: 1rem; }
input { padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; }
button { padding: 0.6rem; background: #4f46e5; color: white; border: none; border-radius: 4px; cursor: pointer; }
.error { color: red; }
</style>
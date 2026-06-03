<template>
  <nav>
    <RouterLink to="/catalogo">Catálogo</RouterLink>
    <RouterLink to="/" v-can="'crear'">Nuevo Producto</RouterLink>
    <span v-if="auth.user" class="badge">{{ auth.user.rol }}</span>
    <RouterLink v-if="!auth.user" to="/login">Login</RouterLink>
    <button v-if="auth.user" @click="auth.logout(); $router.push('/login')">Salir</button>
  </nav>
  <RouterView />
</template>

<script setup>
import { useAuthStore } from '@/stores/auth'
const auth = useAuthStore()
</script>

<style>
nav { display: flex; align-items: center; gap: 1rem; padding: 1rem; background: #4f46e5; }
nav a { color: white; text-decoration: none; font-weight: bold; }
nav a.router-link-active { text-decoration: underline; }
nav button { padding: 0.3rem 0.8rem; background: #ef4444; color: white; border: none; border-radius: 4px; cursor: pointer; }
.badge { background: #818cf8; color: white; padding: 0.2rem 0.6rem; border-radius: 99px; font-size: 0.8rem; }
</style>
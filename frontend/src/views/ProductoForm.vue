<script setup>
import { ref } from 'vue'
import { useForm, useField } from 'vee-validate'
import { productoSchema } from '@/schemas/productoSchema'
import InputField from '@/components/InputField.vue'
import axios from 'axios'

const { handleSubmit, errors, resetForm } = useForm({
  validationSchema: productoSchema
})

const { value: nombre }      = useField('nombre')
const { value: precio }      = useField('precio')
const { value: stock }       = useField('stock')
const { value: descripcion } = useField('descripcion')

const erroresServidor = ref({})
const exito = ref(false)

const onSubmit = handleSubmit(async (values) => {
  try {
    await axios.post('http://localhost:8000/api/productos', values)
    resetForm()
    erroresServidor.value = {}
    exito.value = true
    setTimeout(() => exito.value = false, 3000)
  } catch (e) {
    if (e.response?.status === 422) {
      erroresServidor.value = e.response.data.errors
    }
  }
})
</script>

<template>
  <div class="formulario">
    <h2>Nuevo Producto</h2>

    <div v-if="exito" class="exito">✅ Producto guardado correctamente</div>

    <form @submit.prevent="onSubmit">
      <InputField
        label="Nombre del producto"
        name="nombre"
        v-model="nombre"
        :error="errors.nombre || erroresServidor.nombre?.[0]"
      />
      <InputField
        label="Precio"
        name="precio"
        type="number"
        step="0.01"
        v-model="precio"
        :error="errors.precio || erroresServidor.precio?.[0]"
      />
      <InputField
        label="Stock"
        name="stock"
        type="number"
        v-model="stock"
        :error="errors.stock || erroresServidor.stock?.[0]"
      />
      <InputField
        label="Descripción"
        name="descripcion"
        v-model="descripcion"
        :error="errors.descripcion || erroresServidor.descripcion?.[0]"
      />
      <button type="submit">Guardar producto</button>
    </form>
  </div>
</template>

<style scoped>
.formulario { max-width: 500px; margin: 2rem auto; padding: 2rem; border: 1px solid #ddd; border-radius: 8px; }
h2 { margin-bottom: 1.5rem; }
button { padding: 0.6rem 1.5rem; background: #4f46e5; color: white; border: none; border-radius: 4px; cursor: pointer; }
button:hover { background: #4338ca; }
.exito { background: #d1fae5; color: #065f46; padding: 0.75rem; border-radius: 4px; margin-bottom: 1rem; }
</style>
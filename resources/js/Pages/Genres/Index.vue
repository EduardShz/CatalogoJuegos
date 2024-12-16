<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
import { ref, onMounted } from 'vue'
import axios from 'axios'

const genres = ref([])

const getGenres = async () => {
  try {
    const response = await axios.get('/getgenres') // Ruta para solicitar los datos de todos los géneros
    genres.value = response.data // Pasar todos los datos recibidos a una variable de la vista
  } catch (error) {
    console.error('Error al obtener los géneros:', error)
  }
}

const deleteGenre = async (id) => {
  try {
    await axios.delete(`/deletegenre/${id}`); // Ruta para eliminar un género determinado
    genres.value = genres.value.filter((genre) => genre.id !== id); // Filtra el elemento eliminado
    isActive.value = false; // Esta variable cierra al modal que aparece al intentar eliminar un género
  } catch (error) {
    console.error("Error al eliminar el género:", error);
    isActive.value = false
  }
};

onMounted(getGenres); // Llama a los géneros al cargar la página
</script>

<template>

  <Head title="Géneros" />
  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Géneros
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto px-8">
        <div class="p-6 bg-white rounded border border-blue-grey-lighten-5 mb-4">
          <div class="d-flex justify-space-between">
            <v-btn :href="route('genres.create')" class="bg-indigo-darken-4">
              Añadir Genero
            </v-btn>
          </div>
        </div>

        <div class="p-2 bg-white">
          <h1 class="text-h4 font-weight-bold mb-6">Listado</h1>
          <ul role="list" class="divide-y divide-gray-100">
            <li class="flex justify-between gap-x-2 py-2" v-for="genre in genres" :key="genre.id">
              <div class="flex min-w-0 gap-x-4 pt-2">
                <p class="text-md/5 font-semibold text-gray-900">{{ genre.name }}</p>
              </div>
              <div class="flex min-w-0 gap-x-4 pt-2 pe-4">
                <p class="text-md/5 text-gray-900">
                  <v-btn icon="mdi-pencil-outline" :href="route('genres.edit', genre.id)" variant="text"></v-btn>
                  &nbsp;
                  <v-dialog max-width="500">
                    <template v-slot:activator="{ props: activatorProps }">
                      <v-btn v-bind="activatorProps" icon="mdi-trash-can-outline" variant="text"></v-btn>
                    </template>

                    <template v-slot:default="{ isActive }">
                      <v-card title="Eliminar Género">
                        <v-card-text>
                          ¿Está seguro de eliminar el género <strong>{{ genre.name }}</strong>?
                        </v-card-text>

                        <v-card-actions>
                          <v-spacer></v-spacer>

                          <v-btn text="Cancelar" @click="isActive.value = false"></v-btn>
                          <v-btn text="Eliminar" color="red" @click="deleteGenre(genre.id)"></v-btn>
                        </v-card-actions>
                      </v-card>
                    </template>
                  </v-dialog>
                </p>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
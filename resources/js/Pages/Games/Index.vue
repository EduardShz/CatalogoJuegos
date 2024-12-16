<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
import { ref, onMounted } from 'vue'
import axios from 'axios'

const games = ref([])
const selection = ref([])

const getGames = async () => {
  try {
    const response = await axios.get('/getgames') // Ruta para solicitar los datos de todos los creadores
    games.value = response.data.data // Pasar todos los datos recibidos a una variable de la vista
  } catch (error) {
    console.error('Error al obtener los creadores:', error)
  }
}

const deleteGame = async (id) => {
  try {
    await axios.delete(`/deletegame/${id}`); // Ruta para eliminar un creador determinado
    games.value = games.value.filter((game) => game.id !== id); // Filtra el elemento eliminado
    isActive.value = false; // Esta variable cierra al modal que aparece al intentar eliminar un género
  } catch (error) {
    console.error("Error al eliminar el creador:", error);
    isActive.value = false
  }
};

onMounted(getGames); // Llama a los creadores al cargar la página
</script>

<template>
  <Head title="Juegos" />
  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Juegos
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto px-8">
        <div class="p-6 bg-white rounded border border-blue-grey-lighten-5 mb-4">
          <div class="d-flex justify-space-between">
            <v-btn class="bg-indigo-darken-4" :href="route('games.create')">
              Añadir Juego
            </v-btn>
          </div>
        </div>

        <div class="p-2 bg-white">
          <h1 class="text-h4 font-weight-bold mb-6">Listado</h1>
          <ul role="list" class="divide-y divide-gray-100">
            <li class="flex justify-between gap-x-2 py-2" v-for="game in games" :key="game.id">
              <div class="min-w-0 gap-x-4 pt-2">
                <p class="font-semibold">{{ game.name }}</p>
                <p class="text-caption font-semibold mt-2">{{ game.creator }} - {{ game.published_year }}</p>
              </div>
              <div class="flex min-w-0 gap-x-4 pt-2 pe-4">
                <div class="flex gap-1">
                  <v-rating v-model="game.rating" half-increments hover :length="5" :size="32" color="primary"
                    active-color="amber-accent-2" readonly />

                  <v-item-group v-model="selection">
                    <v-item v-slot="{ isSelected, toggle }">
                      <v-btn :icon="isSelected ? 'mdi-heart' : 'mdi-heart-outline'" @click="toggle"></v-btn>
                    </v-item>
                  </v-item-group>

                  <v-btn icon="mdi-information-outline" :href="route('games.show', game.id)"
                    variant="text"></v-btn>

                  <v-btn icon="mdi-pencil-outline" :href="route('games.edit', game.id)"
                    variant="text"></v-btn>
                  &nbsp;
                  <v-dialog max-width="500">
                    <template v-slot:activator="{ props: activatorProps }">
                      <v-btn v-bind="activatorProps" icon="mdi-trash-can-outline" variant="text"></v-btn>
                    </template>

                    <template v-slot:default="{ isActive }">
                      <v-card title="Eliminar juego">
                        <v-card-text>
                          ¿Está seguro de eliminar <strong>{{ game.name }}</strong>?
                        </v-card-text>

                        <v-card-actions>
                          <v-spacer></v-spacer>

                          <v-btn text="Cancelar" @click="isActive.value = false"></v-btn>
                          <v-btn text="Eliminar" color="red" @click="deleteGame(game.id)"></v-btn>
                        </v-card-actions>
                      </v-card>
                    </template>
                  </v-dialog>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>

</template>
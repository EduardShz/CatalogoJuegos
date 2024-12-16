<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

axios.defaults.headers.common['X-CSRF-TOKEN'] = document.head.querySelector('meta[name="csrf-token"]').content;

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
  <v-app>
    <v-app-bar class="px-3">
      <v-icon>mdi-weather-night</v-icon>
      <v-icon>mdi-weather-night</v-icon>
      <v-btn text="Inicio" class="mr-1" slim :to="{ name: 'home' }"></v-btn>
      <v-btn text="Generos" class="mr-1" slim :to="{ name: 'genres' }"></v-btn>
      <v-btn text="Creadores" class="mr-1" slim :to="{ name: 'creators' }"></v-btn>
      <v-btn text="Juegos" class="mr-1" slim :to="{ name: 'games' }"></v-btn>
    </v-app-bar>

    <v-main>
      <p class="text-h3 font-weight-bold text-center mt-4">Juegos</p>
      <div class="py-12">
        <div class="max-w-7xl mx-auto px-8">
          <div class="p-6 bg-white rounded border border-blue-grey-lighten-5 mb-4">
            <div class="d-flex justify-space-between">
              <v-btn :to="{ name: 'games_create' }" class="bg-indigo-darken-4">
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
                      active-color="amber-accent-2" readonly/>

                    <v-item-group v-model="selection">
                      <v-item v-slot="{ isSelected, toggle }">
                        <v-btn :icon="isSelected ? 'mdi-heart' : 'mdi-heart-outline'" @click="toggle"></v-btn>
                      </v-item>
                    </v-item-group>

                    <v-btn icon="mdi-information-outline" :to="{ name: 'games_show', params: { id: game.id } }"
                      variant="text"></v-btn>

                    <v-btn icon="mdi-pencil-outline" :to="{ name: 'games_edit', params: { id: game.id } }"
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
    </v-main>
  </v-app>
</template>
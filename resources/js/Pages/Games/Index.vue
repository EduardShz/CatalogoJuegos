<script setup>
import LayoutTitle from '@/Own/Components/LayoutTitle.vue'
import { getGames, deleteGame } from '@/api'
import { ref, onMounted } from 'vue'

const games = ref([])
const selection = ref([])

const loadGames = async () => {
  try {
    const { data } = await getGames()

    games.value = data
  } catch (error) {
    console.error('Error al obtener los juegos:', error)
  }
}

const destroyGame = async (id) => {
  try {
    await deleteGame(id) // Ruta para eliminar un género determinado
    games.value = games.value.filter((game) => game.id !== id); // Filtra el elemento eliminado
    isActive.value = false; // Esta variable cierra al modal que aparece al intentar eliminar un género
  } catch (error) {
    console.error("Error al eliminar el juego:", error);
    isActive.value = false
  }
};

onMounted(() => {
  loadGames()
}); // Llama a los géneros al cargar la página
</script>

<template>
  <LayoutTitle title="Juegos" />

  <div class="p-6 bg-white rounded border border-blue-grey-lighten-5 mb-4 py-5 pl-4">
    <div class="d-flex justify-space-between">
      <v-btn class="bg-indigo-darken-4" :to="{ name: 'games_create' }" text="Añadir Juego"></v-btn>
    </div>
  </div>

  <v-table theme="light">
    <thead>
      <tr>
        <th class="text-left">
          <strong>Nombre</strong>
        </th>
        <th class="text-center">
          <strong>Acciones</strong>
        </th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="game in games" :key="game.id" class="">
        <td>
          <strong>{{ game.name }}</strong> <br> {{ game.creator }} - {{ game.published_year }} <br>
          <div class="d-flex justify-left ma-0">
            <p class="ma-0 pt-1">Calificación:</p>
            <v-rating half-increments hover :length="5" :size="32" v-model="game.rating" color="blue"
              active-color="amber-darken-1" readonly />
          </div>
        </td>
        <td class="d-flex justify-center text-center">
          <v-item-group v-model="selection">
            <v-item v-slot="{ isSelected, toggle }">
              <v-btn :icon="isSelected ? 'mdi-heart' : 'mdi-heart-outline'" @click="toggle" variant="text"></v-btn>
            </v-item>
          </v-item-group>

          <v-btn icon="mdi-information-outline" :to="{ name: 'games_show', params: { id: game.id } }" variant="text"></v-btn>

          <v-btn icon="mdi-pencil-outline" :to="{ name: 'games_edit', params: { id: game.id } }" variant="text"></v-btn>

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
                  <v-btn text="Eliminar" color="red" @click="destroyGame(game.id)"></v-btn>
                </v-card-actions>
              </v-card>
            </template>
          </v-dialog>
        </td>
      </tr>
    </tbody>
  </v-table>
</template>
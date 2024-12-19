<script setup>
import LayoutTitle from '@/Own/Components/LayoutTitle.vue'
import { getGames, deleteGame, toggleLikeGame } from '@/api'
import { ref, onMounted } from 'vue'
import axios from 'axios';

const games = ref([])
const roles = ref([])

axios.get('/api/user/roles').then(response => {
  roles.value = response.data.roles;
});

function hasRole(role) {
  return roles.value.includes(role);
}

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

const toggleLike = async (id) => {
  try {
    // Realizar la solicitud para dar like
    await toggleLikeGame(id);
    await loadGames();
  } catch (error) {
    console.error('Error al dar like al juego', error);
  }
};

onMounted(() => {
  loadGames()
});
</script>

<template>
  <LayoutTitle title="Juegos" />

  <div class="p-6 bg-white rounded border border-blue-grey-lighten-5 mb-4 py-5 pl-4" v-if="hasRole('admin')">
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
          <div class="d-flex align-center mr-1">
            <v-btn :icon="game.liked_by_user ? 'mdi-heart' : 'mdi-heart-outline'" @click="toggleLike(game.id)"
              variant="text"></v-btn>
            <p>{{ game.likes_count }}</p>
          </div>

          <v-btn icon="mdi-information-outline" :to="{ name: 'games_show', params: { id: game.id } }"
            variant="text"></v-btn>

          <v-btn icon="mdi-pencil-outline" :to="{ name: 'games_edit', params: { id: game.id } }" variant="text"
            v-if="hasRole('admin')"></v-btn>

          <v-dialog max-width="500" v-if="hasRole('admin')">
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
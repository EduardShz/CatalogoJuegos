<script setup>
import LayoutTitle from '@/Own/Components/LayoutTitle.vue'
import { getCreators, deleteCreator } from '@/api'
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router';
import axios from 'axios';

const creators = ref([])
const route = useRoute()
const roles = ref([])

axios.get('/api/user/roles').then(response => {
  roles.value = response.data.roles;
});

function hasRole(role) {
  return roles.value.includes(role);
}

const loadCreators = async () => {
  try {
    const { data } = await getCreators(route.query)

    creators.value = data
  } catch (error) {
    console.error('Error al obtener los creadores:', error)
  }
}

const destroyCreator = async (id) => {
  try {
    await deleteCreator(id) // Ruta para eliminar un género determinado
    creators.value = creators.value.filter((creator) => creator.id !== id); // Filtra el elemento eliminado
    isActive.value = false; // Esta variable cierra al modal que aparece al intentar eliminar un género
  } catch (error) {
    console.error("Error al eliminar al creador:", error);
    isActive.value = false
  }
};

onMounted(() => {
  loadCreators()
}); // Llama a los creadores al cargar la página
</script>

<template>
  <LayoutTitle title="Creadores" />

  <div class="p-6 bg-white rounded border border-blue-grey-lighten-5 mb-4 py-5 pl-4" v-if="hasRole('admin')">
    <div class="d-flex justify-space-between">
      <v-btn class="bg-indigo-darken-4" :to="{ name: 'creators_create' }" text="Añadir Creador"></v-btn>
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
      <tr v-for="creator in creators" :key="creator.id" class="">
        <td>{{ creator.name }}</td>
        <td class="text-center" v-if="hasRole('admin')">
          <v-btn icon="mdi-pencil-outline" :to="{ name: 'creators_edit', params: { id: creator.id } }"
            variant="text"></v-btn>

          <v-dialog max-width="500">
            <template v-slot:activator="{ props: activatorProps }">
              <v-btn v-bind="activatorProps" icon="mdi-trash-can-outline" variant="text"></v-btn>
            </template>

            <template v-slot:default="{ isActive }">
              <v-card title="Eliminar creador">
                <v-card-text>
                  ¿Está seguro de eliminar a <strong>{{ creator.name }}</strong>?
                </v-card-text>

                <v-card-actions>
                  <v-spacer></v-spacer>

                  <v-btn text="Cancelar" @click="isActive.value = false"></v-btn>
                  <v-btn text="Eliminar" color="red" @click="destroyCreator(creator.id)"></v-btn>
                </v-card-actions>
              </v-card>
            </template>
          </v-dialog>
        </td>
      </tr>
    </tbody>
  </v-table>
</template>
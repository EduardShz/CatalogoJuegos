<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
import { ref, onMounted } from 'vue'
import axios from 'axios'

const creators = ref([])

const getCreators = async () => {
  try {
    const response = await axios.get('/getcreators') // Ruta para solicitar los datos de todos los creadores
    creators.value = response.data // Pasar todos los datos recibidos a una variable de la vista
  } catch (error) {
    console.error('Error al obtener los creadores:', error)
  }
}

const deleteCreator = async (id) => {
  try {
    await axios.delete(`/deletecreator/${id}`); // Ruta para eliminar un creador determinado
    creators.value = creators.value.filter((creator) => creator.id !== id); // Filtra el elemento eliminado
    isActive.value = false; // Esta variable cierra al modal que aparece al intentar eliminar un género
  } catch (error) {
    console.error("Error al eliminar el creador:", error);
    isActive.value = false
  }
};

onMounted(getCreators); // Llama a los creadores al cargar la página
</script>

<template>

  <Head title="Creadores" />
  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Creadores
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto px-8">
        <div class="p-6 bg-white rounded border border-blue-grey-lighten-5 mb-4">
          <div class="d-flex justify-space-between">
            <v-btn :href="route('creators.create')" class="bg-indigo-darken-4">
              Añadir Creador
            </v-btn>
          </div>
        </div>

        <div class="p-2 bg-white">
          <h1 class="text-h4 font-weight-bold mb-6">Listado</h1>
          <ul role="list" class="divide-y divide-gray-100">
            <li class="flex justify-between gap-x-2 py-2" v-for="creator in creators" :key="creator.id">
              <div class="flex min-w-0 gap-x-4 pt-2">
                <p class="text-md/5 font-semibold text-gray-900">{{ creator.name }}</p>
              </div>
              <div class="flex min-w-0 gap-x-4 pt-2 pe-4">
                <p class="text-md/5 text-gray-900">
                  <v-btn icon="mdi-pencil-outline" :href="route('creators.edit', creator.id)" variant="text"></v-btn>
                  &nbsp;
                  <v-dialog max-width="500">
                    <template v-slot:activator="{ props: activatorProps }">
                      <v-btn v-bind="activatorProps" icon="mdi-trash-can-outline" variant="text"></v-btn>
                    </template>

                    <template v-slot:default="{ isActive }">
                      <v-card title="Eliminar Creador">
                        <v-card-text>
                          ¿Está seguro de eliminar a <strong>{{ creator.name }}</strong>?
                        </v-card-text>

                        <v-card-actions>
                          <v-spacer></v-spacer>

                          <v-btn text="Cancelar" @click="isActive.value = false"></v-btn>
                          <v-btn text="Eliminar" color="red" @click="deleteCreator(creator.id)"></v-btn>
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
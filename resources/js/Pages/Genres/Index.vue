<template>
    <v-responsive class="border rounded" max-height="300">
      <v-app :theme="theme">
        <v-app-bar class="px-3">
          <v-btn text="Iniciar Sesión" class="mr-1" slim to="/login"></v-btn>
          <v-btn text="Registrarse" class="ml-1" slim to="/registro"></v-btn>
          <v-btn
            :prepend-icon="theme === 'light' ? 'mdi-weather-sunny' : 'mdi-weather-night'"
            text="Toggle Theme"
            slim
            @click="onClick"
          ></v-btn>
        </v-app-bar>
  
        <v-main>
          <v-container>
            <p class="text-h3 font-weight-bold text-center">Géneros Papá</p>
            <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-6 bg-white border-b border-gray-200 mb-4">
                    <div class="flex justify between">
                        <Link :href="route('generos.create')" class="btn btn-primary">
                            Añadir Género
                        </Link>
                    </div>
                </div>

                <div class="p-2 bg-white">
                    <ul role="list" class="divide-y divide-gray-100">
                        <li class="flex justify-between gap-x-2 py-2" v-for="genre in genres.data">
                            <div class="flex min-w-0 gap-x-4 pt-2">
                                <p class="text-md/5 font-semibold text-gray-900">{{ genre.name }}</p>
                            </div>
                            <div class="flex min-w-0 gap-x-4 pt-2 pe-4" v-if="$page.props.user.permissions.includes('update genres')">
                                <p class="text-md/5 text-gray-900">
                                    <Link :href="route('generos.edit', genre.id)">Editar</Link>
                                    &nbsp;
                                    <button @click="openModal(genre.id)">Eliminar</button>
                                    <Modal :show="modals[genre.id]" maxWidth="lg" @close="closeModal(genre.id)">
                                        <template #default>
                                            <div class="p-4">
                                                <h1 class="text-xl font-bold">Eliminar género</h1>
                                                <p class="mt-2"> ¿Seguro que quieres eliminar <strong> {{ genre.name }} </strong>? </p>
                                                
                                                <form :action="route('generos.destroy', genre.id)" method="POST" class="mt-4">
                                                    <input type="hidden" name="_token" :value="csrfToken">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="button" @click="closeModal(genre.id)" class="btn btn-secondary mt-4">Cerrar</button>
                                                    &nbsp;
                                                    <button type="submit" class="btn btn-danger mt-4"> Eliminar </button>
                                                </form>
                                            </div>
                                        </template>
                                    </Modal>
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
          </v-container>
        </v-main>
      </v-app>
    </v-responsive>
</template>

<script setup>
  import { ref } from 'vue'

  const theme = ref('light')

  function onClick () {
    theme.value = theme.value === 'light' ? 'dark' : 'light'
  }
</script>
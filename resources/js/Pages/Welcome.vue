<template>
    <v-responsive class="border rounded" max-height="300">
      <v-app :theme="theme">
        <v-app-bar class="px-3">
          <v-spacer></v-spacer>
          
          
          <v-btn text="Iniciar Sesión" class="mr-1" slim :to="{ name: 'login'}"></v-btn>
          <v-btn text="Registrarse" class="ml-1" slim :to="{ name: 'register' }"></v-btn>
          <v-btn
            :prepend-icon="theme === 'light' ? 'mdi-weather-sunny' : 'mdi-weather-night'"
            text="Toggle Theme"
            slim
            @click="onClick"
          ></v-btn>
        </v-app-bar>
  
        <v-main>
          <v-container>
            <p class="text-h3 font-weight-bold text-center">Catálogo de Juegos</p>
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
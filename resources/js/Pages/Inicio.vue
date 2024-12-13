<script setup>
import axios from 'axios';

axios.defaults.headers.common['X-CSRF-TOKEN'] = document.head.querySelector('meta[name="csrf-token"]').content;

const logout = async () => {
    try {
        await axios.post('/logoutusers');
        window.location.href = '/login'
    } catch (error) {
        console.error('Error al cerrar sesión:', error);
    }
}

</script>

<template>
    <div>
        <v-responsive class="border rounded" max-height="300">
        <v-app :theme="theme">
            <v-app-bar class="px-3">
                <v-icon>mdi-weather-night</v-icon>
                <v-icon>mdi-weather-night</v-icon>
                <v-btn text="Inicio" class="mr-1" slim :to="{ name: 'home' }"></v-btn>
                <v-btn text="Generos" class="mr-1" slim :to="{ name: 'genres' }"></v-btn>
            </v-app-bar>
    
            <v-main>
            <v-container>
                <p class="text-h3 font-weight-bold text-center">Catálogo de Juegos</p>
            </v-container>
            </v-main>
        </v-app>
        </v-responsive>
    </div>
</template>
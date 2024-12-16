<script setup>
import axios from 'axios';
import { reactive } from 'vue'

axios.defaults.headers.common['X-CSRF-TOKEN'] = document.head.querySelector('meta[name="csrf-token"]').content;

const form = reactive({ // Usar 'reactive' en vez de 'rev'cuando se necesite más de un campo con 'ref'
    name: '',
    loading: false, // 'Loading' se utiliza para cambiar el estado de los botones al crear
})

const storeCreator = async () => {
    form.loading = true;

    try {
        const response = await axios.post('/storecreator', { // Ruta para mandar los datos para crear un nuevo dato al back
            name: form.name,
        });

        console.log('Creador almacenado:', response.data.creator);
        window.location.href='/creadores' // Mandar hacia el index de creadores al terminar la creación
    } catch (error) {
        console.error('Error al guardar al creador:', error.response?.data || error);
        form.loading = false;
    }
};
</script>

<template>
    <v-app>
        <v-app-bar class="px-3">
            <v-icon>mdi-weather-night</v-icon>
            <v-icon>mdi-weather-night</v-icon>
            <v-btn text="Inicio" class="mr-1" slim :to="{ name: 'home' }"></v-btn>
            <v-btn text="Generos" class="mr-1" slim :to="{ name: 'genres' }"></v-btn>
            <v-btn text="Creadores" class="mr-1" slim :to="{ name: 'creators' }" variant="tonal"></v-btn>
            <v-btn text="Juegos" class="mr-1" slim :to="{ name: 'games' }"></v-btn>
        </v-app-bar>

        <v-main>
            <p class="text-h3 font-weight-bold text-center mt-4">Creadores</p>
            <div class="py-12">
                <div class="max-w-7xl mx-auto px-8">
                    <div class="p-2 bg-white">
                        <h1 class="text-h4 font-weight-bold mb-6">Añadir Creador</h1>
                        <form @submit.prevent="storeCreator">
                            <v-card class="mx-auto pa-12 pb-8" elevation="8" max-width="448" rounded="lg">
                                <div class="text-subtitle-1 text-medium-emphasis">Nombre</div>
                                <v-text-field id="name" density="compact" placeholder="Nombre" variant="outlined"
                                    v-model="form.name"></v-text-field>

                                <v-col class="text-end ma-0 pa-0">
                                    <v-btn class="mb-6" text="Crear" color="indigo-darken-4" size="large" :disabled="form.loading"
                                        type="submit"></v-btn>
                                </v-col>
                            </v-card>
                        </form>
                    </div>
                </div>
            </div>
        </v-main>
    </v-app>
</template>
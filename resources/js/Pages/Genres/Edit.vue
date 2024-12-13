<script setup>
import { reactive, onMounted, ref } from 'vue'
import { useRoute } from 'vue-router';
import axios from 'axios';

axios.defaults.headers.common['X-CSRF-TOKEN'] = document.head.querySelector('meta[name="csrf-token"]').content;

const route = useRoute(); // Constante para poder utilizar campos que provengan de la ruta
const form = reactive({ // Usar 'reactive' en vez de 'rev'cuando se necesite más de un campo con 'ref'
    name: '',
    loading: false, // 'Loading' se utiliza para cambiar el estado de los botones al actualizar
})
const genreId = ref(route.params.id); // Inicializando una constante con el id del género apartir de la ruta 

const getGenre = async () => {
    try {
        const response = await axios.get(`/genres/${genreId.value}`); // Llamada de los datos del género
        form.name = response.data.name; // Asignar el nombre obtenido / Es form.name pues ese dato se basó en 'form'
    } catch (error) {
        console.error('Error al cargar el género:', error.response?.data || error);
    }
};

const updateGenre = async () => {
    form.loading = true
    try {
        await axios.put(`/updategenre/${genreId.value}`, { // Ruta para mandar al back la solicitud de actualización
            name: form.name
        });
        console.log('Género actualizado con éxito');
        window.location.href = '/generos' // Mandar hacia el index de géneros al terminar la actualización
    } catch (error) {
        console.error('Error al actualizar el género:', error.response?.data || error);
    }
};

onMounted(getGenre); // Activar la función que llama al género al iniciar la vista
</script>

<template>
    <v-app>
        <v-app-bar class="px-3">
            <v-icon>mdi-weather-night</v-icon>
            <v-icon>mdi-weather-night</v-icon>
            <v-btn text="Inicio" class="mr-1" slim :to="{ name: 'home' }"></v-btn>
            <v-btn text="Generos" class="mr-1" slim :to="{ name: 'genres' }" variant="tonal"></v-btn>
        </v-app-bar>

        <v-main>
            <p class="text-h3 font-weight-bold text-center mt-4">Géneros</p>
            <div class="py-12">
                <div class="max-w-7xl mx-auto px-8">
                    <div class="p-2 bg-white">
                        <h1 class="text-h4 font-weight-bold mb-6">Editar Género</h1>
                        <form @submit.prevent="updateGenre">
                            <v-card class="mx-auto pa-12 pb-8" elevation="8" max-width="448" rounded="lg">
                                <div class="text-subtitle-1 text-medium-emphasis">Nombre</div>
                                <v-text-field id="name" density="compact" placeholder="Nombre" variant="outlined"
                                    v-model="form.name"></v-text-field>

                                <v-col class="text-end ma-0 pa-0">
                                    <v-btn class="mb-6" text="Actualizar" color="indigo-darken-4" size="large"
                                        :disabled="form.loading" type="submit"></v-btn>
                                </v-col>
                            </v-card>
                        </form>
                    </div>
                </div>
            </div>
        </v-main>
    </v-app>
</template>
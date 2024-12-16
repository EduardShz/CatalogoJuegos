<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { reactive, onMounted, ref } from 'vue'
import { Head } from '@inertiajs/vue3'
import axios from 'axios';

const props = defineProps({
    game: {
        type: Object,
        required: true
    }
})

const form = reactive({ // Usar 'reactive' en vez de 'rev' cuando se necesite más de un campo con 'ref'
    name: '',
    published_year: '',
    genre_id: [],
    platform_id: [],
    creator_id: [],
    rating: 1,
    loading: false, // 'Loading' se utiliza para cambiar el estado de los botones al actualizar
})

const gameId = ref(props.game.id); // Inicializando una constante con el id del juego apartir de la ruta 

const getGame = async () => {
    try {
        const response = await axios.get(`/games/${gameId.value}/more`); // Llamada de los datos del juego
        form.name = response.data.name; // Asignar el nombre obtenido / Es form.name pues ese dato se basó en 'form'
        form.published_year = response.data.published_year;
        form.genre_id = response.data.genres;
        form.platform_id = response.data.platforms;
        form.creator_id = response.data.creator;
        form.rating = response.data.rating;
    } catch (error) {
        console.error('Error al cargar el juego:', error.response?.data || error);
    }
};

const selection = ref([])

onMounted(getGame); // Activar la función que llama al creador al iniciar la vista
</script>

<template>

    <Head title="Juegos" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Saber Más
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto px-8">
                <div class="p-2">
                    <h1 class="text-h4 font-weight-bold mb-6">{{ form.name }}</h1>
                    <v-card class="mx-auto pa-12 pb-8" elevation="8" max-width="800" rounded="lg">
                        <div class="flex justify-between">
                            <div>
                                <div class="text-subtitle-1 text-medium-emphasis">Año de Publicación</div>
                                <h1 class="text-h4 font-weight-bold mb-6">{{ form.published_year }}</h1>
                            </div>

                            <div>
                                <v-item-group v-model="selection">
                                    <v-item v-slot="{ isSelected, toggle }">
                                        <v-btn :icon="isSelected ? 'mdi-heart' : 'mdi-heart-outline'"
                                            @click="toggle"></v-btn>
                                    </v-item>
                                </v-item-group>
                            </div>
                        </div>

                        <div class="text-subtitle-1 text-medium-emphasis">Géneros</div>
                        <h1 class="text-h4 font-weight-bold mb-6">{{ form.genre_id.join(', ') }}</h1>

                        <div class="text-subtitle-1 text-medium-emphasis">Plataformas</div>
                        <h1 class="text-h4 font-weight-bold mb-6">{{ form.platform_id.join(', ') }}</h1>

                        <div class="text-subtitle-1 text-medium-emphasis">Creadores</div>
                        <h1 class="text-h4 font-weight-bold mb-6">{{ form.creator_id }}</h1>

                        <div class="text-subtitle-1 text-medium-emphasis">Calificación</div>
                        <v-rating v-model="form.rating" half-increments hover :length="5" :size="32" color="primary"
                            active-color="amber-accent-2" readonly />

                        <v-col class="text-end ma-0 pa-0">
                            <v-btn class="mb-6" text="Regresar" color="indigo-darken-4" size="large"
                                :disabled="form.loading"></v-btn>
                        </v-col>
                    </v-card>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
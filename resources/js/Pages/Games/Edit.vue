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

const gameId = ref(props.game.id);

const getGame = async () => {
    try {
        const response = await axios.get(`/games/${gameId.value}`); // Llamada de los datos del creador
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

const genres = ref([])
const platforms = ref([])
const currentYear = new Date().getFullYear();
const years = Array.from({ length: 50 }, (_, i) => (currentYear - i).toString());
const creators = ref([])

const getGenres = async () => {
    try {
        const responseGenres = await axios.get('/getgenres')

        genres.value = responseGenres.data
    } catch (error) {
        console.error('Error al obtener los géneros:', error)
    }
}

const getPlatforms = async () => {
    try {
        const responsePlatforms = await axios.get('/getplatforms')

        platforms.value = responsePlatforms.data
    } catch (error) {
        console.error('Error al obtener a los creadores:', error)
    }
}

const getCreators = async () => {
    try {
        const responseCreators = await axios.get('/getcreators')

        creators.value = responseCreators.data
    } catch (error) {
        console.error('Error al obtener a los creadores:', error)
    }
}

const updateGame = async () => {
    form.loading = true
    try {
        await axios.put(`/updategame/${gameId.value}`, { // Ruta para mandar al back la solicitud de actualización
            name: form.name,
            published_year: form.published_year,
            genre_id: Object.values(form.genre_id),
            platform_id: Object.values(form.platform_id),
            creator_id: form.creator_id,
            rating: form.rating,
        });

        console.log('Juego actualizado con éxito');
        window.location.href = '/juegos' // Mandar hacia el index de creador al terminar la actualización
    } catch (error) {
        console.error('Error al actualizar el juego:', error.response?.data || error);
        console.log(form.name);
        form.loading = false;
    }
};

onMounted(getGame); // Activar la función que llama al creador al iniciar la vista
onMounted(getGenres);
onMounted(getPlatforms);
onMounted(getCreators);
</script>

<template>

    <Head title="Editar Juego" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Editar Juego
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto px-8">
                <div class="p-2">
                    <form @submit.prevent="updateGame">
                        <v-card class="mx-auto pa-12 pb-8" elevation="8" max-width="800" rounded="lg">
                            <div class="text-subtitle-1 text-medium-emphasis">Nombre</div>
                            <v-text-field id="name" density="compact" placeholder="Nombre" variant="outlined"
                                v-model="form.name"></v-text-field>

                            <div class="text-subtitle-1 text-medium-emphasis">Año de Publicación</div>
                            <v-select v-model="form.published_year" :items="years" label="Selecciona un año"></v-select>

                            <div class="text-subtitle-1 text-medium-emphasis">Géneros</div>
                            <v-select v-model="form.genre_id" :items="genres" item-title="name" item-value="id"
                                label="Géneros" chips multiple></v-select>

                            <div class="text-subtitle-1 text-medium-emphasis">Plataformas</div>
                            <v-select v-model="form.platform_id" :items="platforms" item-title="name" item-value="id"
                                label="Plataformas" chips multiple></v-select>

                            <div class="text-subtitle-1 text-medium-emphasis">Creadores</div>
                            <v-select v-model="form.creator_id" :items="creators" item-title="name" item-value="id"
                                label="Creadores"></v-select>

                            <div class="text-subtitle-1 text-medium-emphasis">Calificación</div>
                            <v-rating v-model="form.rating" half-increments hover :length="5" :size="32" color="primary"
                                active-color="amber-accent-2" />

                            <v-col class="text-end ma-0 pa-0">
                                <v-btn class="mb-6" text="Actualizar" color="indigo-darken-4" size="large"
                                    :disabled="form.loading" type="submit"></v-btn>
                            </v-col>
                        </v-card>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
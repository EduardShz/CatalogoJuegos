<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { onMounted, reactive, ref } from 'vue'
import axios from 'axios';
import { Head } from '@inertiajs/vue3'

const tab = ref();

const form = reactive({ // Usar 'reactive' en vez de 'rev'cuando se necesite más de un campo con 'ref'
    name: '',
    published_year: '',
    genre_id: [],
    platform_id: [],
    creator_id: [],
    rating: 1,
    loading: false, // 'Loading' se utiliza para cambiar el estado de los botones al crear
})

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

const storeGame = async () => {
    form.loading = true;

    try {
        const response = await axios.post('/storegame', { // Ruta para mandar los datos para crear un nuevo dato al back
            name: form.name,
            published_year: form.published_year,
            genre_id: Object.values(form.genre_id),
            platform_id: Object.values(form.platform_id),
            creator_id: form.creator_id,
            rating: form.rating,
        });

        console.log('Creador almacenado:', response.data.creator);
        window.location.href = '/juegos' // Mandar hacia el index de juegos al terminar la creación
    } catch (error) {
        console.error('Error al guardar el juego:', error.response?.data || error);
        console.log(form.creator_id)
        form.loading = false;
    }
};


// Métodos para crear un género
const genreForm = reactive({ // Usar 'reactive' en vez de 'rev'cuando se necesite más de un campo con 'ref'
    name: ''
})

const storeGenre = async () => {
    try {
        const responseGenre = await axios.post('/storegenre', { // Ruta para mandar los datos para crear un nuevo dato al back
            name: genreForm.name,
        });

        window.location.href = '/juegos/create'
        console.log('Género almacenado:', responseGenre.data.genre);
        onMounted(getCreators);
    } catch (error) {
        console.error('Error al guardar el género:', error.responseGenre?.data || error);
    }
};


// Métodos para crear un creador
const creatorForm = reactive({ // Usar 'reactive' en vez de 'rev'cuando se necesite más de un campo con 'ref'
    name: ''
})

const storeCreator = async () => {
    try {
        const responseCreator = await axios.post('/storecreator', { // Ruta para mandar los datos para crear un nuevo dato al back
            name: creatorForm.name,
        });

        window.location.href = '/juegos/create'
        console.log('Creador almacenado:', responseCreator.data.creator);
    } catch (error) {
        console.error('Error al guardar al creador:', error.responseCreator?.data || error);
    }
};

onMounted(getGenres);
onMounted(getPlatforms);
onMounted(getCreators);
</script>

<template>

    <Head title="Crear Juego" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Crear Juego
            </h2>
        </template>

        <v-card class="bg-transparent">
            <v-tabs v-model="tab" align-tabs="center" color="deep-purple-accent-4" class="bg-white">
                <v-tab :value="1">Juegos</v-tab>
                <v-tab :value="2">Géneros</v-tab>
                <v-tab :value="3">Creadores</v-tab>
            </v-tabs>

            <v-tabs-window v-model="tab">
                <v-tabs-window-item :value="1">
                    <div class="py-12">
                        <div class="max-w-7xl mx-auto px-8">
                            <div class="p-2">
                                <form @submit.prevent="storeGame">
                                    <v-card class="mx-auto pa-12 pb-8" elevation="8" max-width="800" rounded="lg">
                                        <div class="text-subtitle-1 text-medium-emphasis">Nombre</div>
                                        <v-text-field id="name" density="compact" placeholder="Nombre"
                                            variant="outlined" v-model="form.name"></v-text-field>

                                        <div class="text-subtitle-1 text-medium-emphasis">Año de Publicación
                                        </div>
                                        <v-select v-model="form.published_year" :items="years"
                                            label="Selecciona un año"></v-select>

                                        <div class="text-subtitle-1 text-medium-emphasis">Géneros</div>
                                        <v-select v-model="form.genre_id" :items="genres" item-title="name"
                                            item-value="id" label="Géneros" chips multiple></v-select>

                                        <div class="text-subtitle-1 text-medium-emphasis">Plataformas</div>
                                        <v-select v-model="form.platform_id" :items="platforms" item-title="name"
                                            item-value="id" label="Plataformas" chips multiple></v-select>

                                        <div class="text-subtitle-1 text-medium-emphasis">Creadores</div>
                                        <v-select v-model="form.creator_id" :items="creators" item-title="name"
                                            item-value="id" label="Creadores"></v-select>

                                        <div class="text-subtitle-1 text-medium-emphasis">Calificación</div>
                                        <v-rating v-model="form.rating" half-increments hover :length="5" :size="32"
                                            color="primary" active-color="amber-accent-2" />

                                        <v-col class="text-end ma-0 pa-0">
                                            <v-btn class="mb-6" text="Crear" color="indigo-darken-4" size="large"
                                                :disabled="form.loading" type="submit"></v-btn>
                                        </v-col>
                                    </v-card>
                                </form>
                            </div>
                        </div>
                    </div>
                </v-tabs-window-item>
                <v-tabs-window-item :value="2">
                    <div class="py-12">
                        <div class="max-w-7xl mx-auto px-8">
                            <div class="p-2">
                                <form @submit.prevent="storeGenre">
                                    <v-card class="mx-auto pa-12 pb-8" elevation="8" max-width="448" rounded="lg">
                                        <div class="text-subtitle-1 text-medium-emphasis">Nombre</div>
                                        <v-text-field id="name" density="compact" placeholder="Nombre"
                                            variant="outlined" v-model="genreForm.name"></v-text-field>

                                        <v-col class="text-end ma-0 pa-0">
                                            <v-btn class="mb-6" text="Crear" color="indigo-darken-4" size="large"
                                                type="submit"></v-btn>
                                        </v-col>
                                    </v-card>
                                </form>
                            </div>
                        </div>
                    </div>
                </v-tabs-window-item>
                <v-tabs-window-item :value="3">
                    <div class="py-12">
                        <div class="max-w-7xl mx-auto px-8">
                            <div class="p-2">
                                <form @submit.prevent="storeCreator">
                                    <v-card class="mx-auto pa-12 pb-8" elevation="8" max-width="448" rounded="lg">
                                        <div class="text-subtitle-1 text-medium-emphasis">Nombre</div>
                                        <v-text-field id="name" density="compact" placeholder="Nombre"
                                            variant="outlined" v-model="creatorForm.name"></v-text-field>

                                        <v-col class="text-end ma-0 pa-0">
                                            <v-btn class="mb-6" text="Crear" color="indigo-darken-4" size="large"
                                                type="submit"></v-btn>
                                        </v-col>
                                    </v-card>
                                </form>
                            </div>
                        </div>
                    </div>
                </v-tabs-window-item>
            </v-tabs-window>
        </v-card>
    </AuthenticatedLayout>
</template>
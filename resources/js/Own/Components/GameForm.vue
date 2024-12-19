<script setup>
import { useRoute, useRouter } from 'vue-router'
import { storeGame, getGame, updateGame, getPlatforms } from '@/api'
import { onMounted, ref } from 'vue'

const props = defineProps({
    genres: {
        type: Array,
        required: true,
    },
    creators: {
        type: Array,
        required: true,
    }
});

const form = ref({
    name: '',
    published_year: '',
    genre_id: [],
    platform_id: [],
    creator_id: [],
    rating: 1,
})
const router = useRouter()
const route = useRoute()
const loading = ref()
const update = ref(false)
const platforms = ref([])
const currentYear = new Date().getFullYear();
const years = Array.from({ length: 50 }, (_, i) => (currentYear - i).toString());
const errorMessages = ref({})

const loadGame = async () => {
    const data = await getGame(route.params.id)
    form.value = data
}

const loadPlatforms = async () => {
    const dataPlatforms = await getPlatforms()
    platforms.value = dataPlatforms.data
}

onMounted(() => {
    if (route.params.id) {
        loadGame()
        update.value = true;
    }
    loadPlatforms();
});

const saveGame = async () => {
    loading.value = true;

    if (route.params.id) {
        try {
            await updateGame(route.params.id, form.value)

            router.push({ name: 'games' });
        } catch (error) {
            if (error.response.status == 422) {
                errorMessages.value = error.response.data.errors
                console.error('Error al editar el juego:', error)
                loading.value = false;

                return errorMessages
            }
        }
    } else {
        try {
            await storeGame(form.value)

            router.push({ name: 'games' });
        } catch (error) {
            if (error.response.status == 422) {
                errorMessages.value = error.response.data.errors
                console.error('Error al guardar el juego:', error)
                loading.value = false;

                return errorMessages
            }
        }
    }
};
</script>

<template>
    <form @submit.prevent="saveGame">
        <v-card class="mx-auto pa-12 pb-8" elevation="8" max-width="800" rounded="lg">
            <div class="text-subtitle-1 text-medium-emphasis">Nombre</div>
            <v-text-field id="name" density="compact" placeholder="Nombre" variant="outlined" v-model="form.name"
                :error-messages="errorMessages.name"></v-text-field>

            <div class="text-subtitle-1 text-medium-emphasis">Año de Publicación
            </div>
            <v-select v-model="form.published_year" :items="years" label="Selecciona un año"
                :error-messages="errorMessages.published_year"></v-select>

            <div class="text-subtitle-1 text-medium-emphasis">Géneros</div>
            <v-select v-model="form.genre_id" :items="genres" item-title="name" item-value="id" label="Géneros" chips
                multiple :error-messages="errorMessages.genre_id"></v-select>

            <div class="text-subtitle-1 text-medium-emphasis">Plataformas</div>
            <v-select v-model="form.platform_id" :items="platforms" item-title="name" item-value="id"
                label="Plataformas" chips multiple :error-messages="errorMessages.platform_id"></v-select>

            <div class="text-subtitle-1 text-medium-emphasis">Creadores</div>
            <v-select v-model="form.creator_id" :items="creators" item-title="name" item-value="id" label="Creadores"
                :error-messages="errorMessages.creator_id"></v-select>

            <div class="text-subtitle-1 text-medium-emphasis">Calificación</div>
            <v-rating v-model="form.rating" half-increments hover :length="5" :size="32" color="primary"
                active-color="amber-accent-2" :error-messages="errorMessages.rating" />

            <v-col class="text-end ma-0 pa-0">
                <v-btn class="mb-6" color="indigo-darken-4" size="large" :disabled="loading" type="submit">
                    {{ update ? 'Actualizar' : 'Añadir' }}
                </v-btn>
            </v-col>
        </v-card>
    </form>
</template>
<script setup>
import LayoutTitle from '@/Own/Components/LayoutTitle.vue'
import GameForm from '@/Own/Components/GameForm.vue'
import GenreForm from '@/Own/Components/GenreForm.vue'
import CreatorForm from '@/Own/Components/CreatorForm.vue'
import { getGenres, getCreators } from '@/api'
import { ref, onMounted } from 'vue';

const tab = ref();
const genres = ref([])
const creators = ref([])

const loadGenres = async () => {
    const dataGenres = await getGenres()
    genres.value = dataGenres.data
}

const loadCreators = async () => {
    const dataCreators = await getCreators()
    creators.value = dataCreators.data
}

const genreToGame = () => {
  tab.value = 1; 
  loadGenres()
}
const creatorToGame = () => {
  tab.value = 1; 
  loadCreators()
}

onMounted(() => {
  loadGenres();
  loadCreators();  // Cargar géneros al cargar el componente
});
</script>

<template>
    <LayoutTitle title="Añadir Juego" />

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
                            <GameForm :genres="genres" :creators="creators"></GameForm>
                        </div>
                    </div>
                </div>
            </v-tabs-window-item>
            <v-tabs-window-item :value="2">
                <div class="py-12">
                    <div class="max-w-7xl mx-auto px-8">
                        <div class="p-2">
                            <GenreForm :state="'inGame'" @saved="genreToGame"/>
                        </div>
                    </div>
                </div>
            </v-tabs-window-item>
            <v-tabs-window-item :value="3">
                <div class="py-12">
                    <div class="max-w-7xl mx-auto px-8">
                        <div class="p-2">
                            <CreatorForm :state="'inGame'" @saved="creatorToGame"></CreatorForm>
                        </div>
                    </div>
                </div>
            </v-tabs-window-item>
        </v-tabs-window>
    </v-card>
</template>
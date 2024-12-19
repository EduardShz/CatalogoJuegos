<script setup>
import LayoutTitle from '@/Own/Components/LayoutTitle.vue'
import GameForm from '@/Own/Components/GameForm.vue'
import { getGenres, getCreators } from '@/api'
import { ref, onMounted } from 'vue';

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

onMounted(() => {
    loadGenres();
    loadCreators();
});
</script>

<template>
    <LayoutTitle title="Editar Juego" />

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-8">
            <div class="p-2">
                <GameForm :genres="genres" :creators="creators"></GameForm>
            </div>
        </div>
    </div>
</template>
<script setup>
import LayoutTitle from '@/Own/Components/LayoutTitle.vue'
import CommentForm from '@/Own/Components/CommentForm.vue'
import { useRoute } from 'vue-router'
import { onMounted, ref } from 'vue'
import { getShowGame, getComments } from '@/api';

const form = ref({ // Usar 'reactive' en vez de 'rev' cuando se necesite más de un campo con 'ref'
    name: '',
    published_year: '',
    genres: [],
    platforms: [],
    creator: [],
    rating: 1,
})
const loading = ref(false)
const route = useRoute()
const selection = ref([])
const comments = ref([])

const loadGame = async () => {
    const data = await getShowGame(route.params.id)
    form.value = data
}

const loadComments = async () => {
    const data = await getComments(route.params.id)
    comments.value = data;
    console.log(data)
}

const addComment = async () => {
    loadComments()
}

onMounted(() => {
    loadGame()
    loadComments()
});
</script>

<template>
    <LayoutTitle :title="'Más información - ' + form.name" />

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-8">
            <div class="p-2">
                <v-card class="mx-auto pa-12 pb-8" elevation="8" max-width="800" rounded="lg">
                    <div class="d-flex justify-space-between">
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
                    <h1 class="text-h4 font-weight-bold mb-6">{{ form.genres.join(', ') }}</h1>

                    <div class="text-subtitle-1 text-medium-emphasis">Plataformas</div>
                    <h1 class="text-h4 font-weight-bold mb-6">{{ form.platforms.join(', ') }}</h1>

                    <div class="text-subtitle-1 text-medium-emphasis">Creadores</div>
                    <h1 class="text-h4 font-weight-bold mb-6">{{ form.creator }}</h1>

                    <div class="text-subtitle-1 text-medium-emphasis">Calificación</div>
                    <v-rating v-model="form.rating" half-increments hover :length="5" :size="32" color="primary"
                        active-color="amber-accent-2" readonly />

                    <v-col class="text-end ma-0 pa-0">
                        <v-btn class="mb-6" text="Regresar" color="indigo-darken-4" size="large" :disabled="loading"
                            :to="{ name: 'games' }"></v-btn>
                    </v-col>

                    <h1 class="text-h4 font-weight-bold mb-6">Comentarios</h1>
                    <CommentForm :state="'Create'" @submitComment="addComment"></CommentForm>
                    <br>
                    <div v-for="comment in comments" :key="comment.id">
                        <p><strong>{{ comment.user.username }}</strong> - {{ comment.created_at }}</p>
                        <p>{{ comment.content }}</p>
                    </div>
                </v-card>
            </div>
        </div>
    </div>
</template>
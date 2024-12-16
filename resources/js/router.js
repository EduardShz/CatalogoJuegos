import { createWebHistory, createRouter } from 'vue-router'
import Welcome from './Pages/Bienvenida.vue'
import Gato from './Pages/Gato.vue'
import GenresIndex from './Pages/Genres/Index.vue'
import GenreCreate from './Pages/Genres/Create.vue'
import GenreEdit from './Pages/Genres/Edit.vue'
import CreatorsIndex from './Pages/Creators/Index.vue'
import CreatorCreate from './Pages/Creators/Create.vue'
import CreatorEdit from './Pages/Creators/Edit.vue'
import GamesIndex from './Pages/Games/Index.vue'
import GameCreate from './Pages/Games/Create.vue'
import GameEdit from './Pages/Games/Edit.vue'
import GameShow from './Pages/Games/Show.vue'

const routes = [
    { path: '/', component: Welcome, name: 'welcome' },
    { path: '/gato', component: Gato },
    { path: '/generos', component: GenresIndex, name: 'genres' },
    { path: '/generos/create', component: GenreCreate, name: 'genres_create' },
    { path: '/generos/:id/edit', component: GenreEdit, name: 'genres_edit', props: true }, // 'props' es utilizado para mandar los datos que contenga la ruta a la vista
    { path: '/creadores', component: CreatorsIndex, name: 'creators' },
    { path: '/creadores/create', component: CreatorCreate, name: 'creators_create' },
    { path: '/creadores/:id/edit', component: CreatorEdit, name: 'creators_edit', props: true },
    { path: '/juegos', component: GamesIndex, name: 'games' },
    { path: '/juegos/create', component: GameCreate, name: 'games_create' },
    { path: '/juegos/:id/edit', component: GameEdit, name: 'games_edit', props: true },
    { path: '/juegos/:id/', component: GameShow, name: 'games_show', props: true },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router




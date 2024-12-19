import { createWebHistory, createRouter } from 'vue-router'
import Inicio from './Pages/Inicio.vue'
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
import Login from './Pages/Auth/Login.vue'

const routes = [
    { path: '/', component: Inicio, name: 'home' },
    { path: '/login', component: Login, name: 'login' },
    { path: '/generos', component: GenresIndex, name: 'genres' },
    { path: '/generos/create', component: GenreCreate, name: 'genres_create' },
    { path: '/generos/:id/edit', component: GenreEdit, name: 'genres_edit' },
    { path: '/creadores', component: CreatorsIndex, name: 'creators' },
    { path: '/creadores/create', component: CreatorCreate, name: 'creators_create' },
    { path: '/creadores/:id/edit', component: CreatorEdit, name: 'creators_edit'},
    { path: '/juegos', component: GamesIndex, name: 'games' },
    { path: '/juegos/create', component: GameCreate, name: 'games_create' },
    { path: '/juegos/:id/edit', component: GameEdit, name: 'games_edit'},
    { path: '/juegos/:id/', component: GameShow, name: 'games_show', props: true },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router




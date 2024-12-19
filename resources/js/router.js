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
import Register from './Pages/Auth/Register.vue'
import Welcome from './Pages/Welcome.vue'

const routes = [
    { path: '/', component: Welcome, name: 'welcome' },
    { path: '/login', component: Login, name: 'login' },
    { path: '/register', component: Register, name: 'register' },
    { path: '/inicio', component: Inicio, name: 'home',  meta: { requiresAuth: true } },
    { path: '/generos', component: GenresIndex, name: 'genres',  meta: { requiresAuth: true } },
    { path: '/generos/create', component: GenreCreate, name: 'genres_create',  meta: { requiresAuth: true } },
    { path: '/generos/:id/edit', component: GenreEdit, name: 'genres_edit',  meta: { requiresAuth: true } },
    { path: '/creadores', component: CreatorsIndex, name: 'creators',  meta: { requiresAuth: true } },
    { path: '/creadores/create', component: CreatorCreate, name: 'creators_create',  meta: { requiresAuth: true } },
    { path: '/creadores/:id/edit', component: CreatorEdit, name: 'creators_edit',  meta: { requiresAuth: true } },
    { path: '/juegos', component: GamesIndex, name: 'games',  meta: { requiresAuth: true } },
    { path: '/juegos/create', component: GameCreate, name: 'games_create',  meta: { requiresAuth: true } },
    { path: '/juegos/:id/edit', component: GameEdit, name: 'games_edit',  meta: { requiresAuth: true } },
    { path: '/juegos/:id/', component: GameShow, name: 'games_show',  meta: { requiresAuth: true } },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

router.beforeEach((to, from, next) => {
    const isAuthenticated = localStorage.getItem('token');  // Verifica si existe el token

    // Si la ruta requiere autenticación y no está autenticado, redirige al login
    if (to.matched.some(record => record.meta.requiresAuth) && !isAuthenticated) {
        next({ name: 'login' });
    } else {
        next();  // Si está autenticado o la ruta no requiere autenticación, permite continuar
    }
});

export default router




import { createWebHistory, createRouter } from 'vue-router'
import Welcome from './Pages/Welcome.vue'
import Gato from './Pages/Gato.vue'
import Login from './Pages/Login.vue'
import Register from './Pages/Register.vue'
import Inicio from './Pages/Inicio.vue'
import GenresIndex from './Pages/Genres/Index.vue'

const routes = [
    { path: '/', component: Welcome, name: 'welcome' },
    { path: '/gato', component: Gato },
    { path: '/login', component: Login, name: 'login' },
    { path: '/registro', component: Register, name: 'register' },
    { path: '/inicio', component: Inicio, name: 'home', meta: { requiresAuth: true } },
    { path: '/generos', component: GenresIndex, name: 'genres' },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router




import { createWebHistory, createRouter } from 'vue-router'
import axios from 'axios'
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
    { path: '/generos/create', component: GenreCreate, name: 'genres_create',  meta: { requiresAuth: true, roles: ['admin'] } },
    { path: '/generos/:id/edit', component: GenreEdit, name: 'genres_edit',  meta: { requiresAuth: true, roles: ['admin'] } },
    { path: '/creadores', component: CreatorsIndex, name: 'creators',  meta: { requiresAuth: true } },
    { path: '/creadores/create', component: CreatorCreate, name: 'creators_create',  meta: { requiresAuth: true, roles: ['admin'] } },
    { path: '/creadores/:id/edit', component: CreatorEdit, name: 'creators_edit',  meta: { requiresAuth: true, roles: ['admin'] } },
    { path: '/juegos', component: GamesIndex, name: 'games',  meta: { requiresAuth: true } },
    { path: '/juegos/create', component: GameCreate, name: 'games_create',  meta: { requiresAuth: true, roles: ['admin'] } },
    { path: '/juegos/:id/edit', component: GameEdit, name: 'games_edit',  meta: { requiresAuth: true, roles: ['admin'] } },
    { path: '/juegos/:id/', component: GameShow, name: 'games_show',  meta: { requiresAuth: true } },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

router.beforeEach(async (to, from, next) => {
    const token = localStorage.getItem('token'); // Obtén el token de autenticación

    if (to.matched.some(record => record.meta.requiresAuth) && !token) {
        // Si la ruta requiere autenticación y no hay token, redirige al login
        next({ name: 'login' });
    } else if (to.matched.some(record => record.meta.roles)) {
        try {
            // Verifica los roles del usuario autenticado
            const response = await axios.get('/api/user/roles', {
                headers: { Authorization: `Bearer ${token}` },
            });

            const userRoles = response.data.roles; // Obtén los roles del usuario
            const allowedRoles = to.meta.roles; // Roles permitidos para la ruta

            // Comprueba si hay intersección entre los roles del usuario y los permitidos
            const hasAccess = userRoles.some(role => allowedRoles.includes(role));

            if (hasAccess) {
                next(); // El usuario tiene permiso para acceder
            } else {
                next({ name: 'home' }); // Redirige a una página de inicio si no tiene permiso
            }
        } catch (error) {
            console.error('Error al verificar roles:', error);
            next({ name: 'login' }); // Redirige al login si ocurre un error
        }
    } else {
        next(); // Si no se requiere autenticación o roles, permite continuar
    }
});

export default router




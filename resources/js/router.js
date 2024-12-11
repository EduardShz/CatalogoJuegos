import { createWebHistory, createRouter } from 'vue-router'
import Inicio from './Inicio.vue'
import Gato from './Gato.vue'

const routes = [
    { path: '/', component: Inicio },
    { path: '/gato', component: Gato },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router




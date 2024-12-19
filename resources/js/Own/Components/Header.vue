<script setup>
import axios from 'axios';
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const form = ref({})
const router = useRouter()

const logOut = async () => {
    const response = await axios.post('/api/logout', form.value)
    router.push({ name: 'login' })
}
</script>

<template>
    <v-app>
        <!-- Barra de Navegación -->
        <v-app-bar color="red" elevation="1">
            <v-container class="d-flex justify-space-between align-center">
                <div class="d-flex align-center">
                    <!-- Logo -->
                    <v-btn to="/" variant="text" class="mr-4">
                        <v-icon>mdi-home</v-icon>
                    </v-btn>

                    <!-- Enlaces de Navegación -->
                    <v-btn text="Inicio" :to="{ name: 'home' }" variant="text" class="mx-2"></v-btn>
                    <v-btn text="Juegos" :to="{ name: 'games' }" variant="text" class="mx-2"></v-btn>
                    <v-btn text="Géneros" :to="{ name: 'genres' }" variant="text" class="mx-2"></v-btn>
                    <v-btn text="Creadores" :to="{ name: 'creators' }" variant="text" class="mx-2"></v-btn>
                </div>

                <!-- Dropdown Configuración -->
                <v-menu offset-y>
                    <template v-slot:activator="{ props }">
                        <v-btn v-bind="props" variant="text" class="d-flex align-center">
                            Usuario
                            <v-icon class="ml-2">mdi-menu-down</v-icon>
                        </v-btn>
                    </template>
                    <v-list>
                        <v-list-item :to="{ name: 'home' }">
                            <v-list-item-title>Configurar Perfil</v-list-item-title>
                        </v-list-item>
                        <v-list-item @click="logOut">
                            <v-list-item-title>Cerrar Sesión</v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-menu>
            </v-container>
        </v-app-bar>


            <v-main class="bg-grey-lighten-4">
                <v-container>
                    <slot />
                </v-container>
            </v-main>
    </v-app>
</template>
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
import axios from 'axios';
import { reactive } from 'vue'

const form = reactive({ // Usar 'reactive' en vez de 'rev'cuando se necesite más de un campo con 'ref'
    name: '',
    loading: false, // 'Loading' se utiliza para cambiar el estado de los botones al crear
})

const storeGenre = async () => {
    form.loading = true;

    try {
        const response = await axios.post('/storegenre', { // Ruta para mandar los datos para crear un nuevo dato al back
            name: form.name,
        });

        console.log('Género almacenado:', response.data.genre);
        window.location.href = '/generos' // Mandar hacia el index de géneros al terminar la creación
    } catch (error) {
        console.error('Error al guardar el género:', error.response?.data || error);
        form.loading = false;
    }
};
</script>

<template>

    <Head title="Géneros" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Añadir Género
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto px-8">
                <div class="p-2">
                    <form @submit.prevent="storeGenre">
                        <v-card class="mx-auto pa-12 pb-8" elevation="8" max-width="448" rounded="lg">
                            <div class="text-subtitle-1 text-medium-emphasis">Nombre</div>
                            <v-text-field id="name" density="compact" placeholder="Nombre" variant="outlined"
                                v-model="form.name"></v-text-field>

                            <v-col class="text-end ma-0 pa-0">
                                <v-btn class="mb-6" text="Crear" color="indigo-darken-4" size="large"
                                    :disabled="form.loading" type="submit"></v-btn>
                            </v-col>
                        </v-card>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
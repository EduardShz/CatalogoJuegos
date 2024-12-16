<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { onMounted, reactive, ref } from 'vue'
import axios from 'axios';

const form = reactive({ // Usar 'reactive' en vez de 'rev'cuando se necesite más de un campo con 'ref'
    name: '',
    loading: false, // 'Loading' se utiliza para cambiar el estado de los botones al crear
})

const storeCreator = async () => {
    form.loading = true;

    try {
        const response = await axios.post('/storecreator', { // Ruta para mandar los datos para crear un nuevo dato al back
            name: form.name,
        });

        console.log('Creador almacenado:', response.data.creator);
        window.location.href = '/creadores' // Mandar hacia el index de creadores al terminar la creación
    } catch (error) {
        console.error('Error al guardar al creador:', error.response?.data || error);
        form.loading = false;
    }
};
</script>

<template>

    <Head title="Creadores" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Añadir Creador
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto px-8">
                <div class="p-2">
                    <h1 class="text-h4 font-weight-bold mb-6">Añadir Creador</h1>
                    <form @submit.prevent="storeCreator">
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
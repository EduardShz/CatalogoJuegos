<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { onMounted, reactive, ref } from 'vue'
import axios from 'axios';

const props = defineProps({
    creator: {
        type: Object,
        required: true
    }
})

const form = reactive({ // Usar 'reactive' en vez de 'rev' cuando se necesite más de un campo con 'ref'
    name: '',
    loading: false, // 'Loading' se utiliza para cambiar el estado de los botones al actualizar
})
const creatorId = ref(props.creator.id); // Inicializando una constante con el id del creador apartir de la ruta 

const getCreator = async () => {
    try {
        const response = await axios.get(`/creators/${creatorId.value}`); // Llamada de los datos del creador
        form.name = response.data.name; // Asignar el nombre obtenido / Es form.name pues ese dato se basó en 'form'
    } catch (error) {
        console.error('Error al cargar al creador:', error.response?.data || error);
    }
};

const updateCreator = async () => {
    form.loading = true
    try {
        await axios.put(`/updatecreator/${creatorId.value}`, { // Ruta para mandar al back la solicitud de actualización
            name: form.name
        });
        console.log('Creador actualizado con éxito');
        window.location.href = '/creadores' // Mandar hacia el index de creador al terminar la actualización
    } catch (error) {
        console.error('Error al actualizar al creador:', error.response?.data || error);
    }
};

onMounted(getCreator); // Activar la función que llama al creador al iniciar la vista
</script>

<template>

    <Head title="Creadores" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Editar Creador
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto px-8">
                <div class="p-2">
                    <form @submit.prevent="updateCreator">
                        <v-card class="mx-auto pa-12 pb-8" elevation="8" max-width="448" rounded="lg">
                            <div class="text-subtitle-1 text-medium-emphasis">Nombre</div>
                            <v-text-field id="name" density="compact" placeholder="Nombre" variant="outlined"
                                v-model="form.name"></v-text-field>

                            <v-col class="text-end ma-0 pa-0">
                                <v-btn class="mb-6" text="Actualizar" color="indigo-darken-4" size="large"
                                    :disabled="form.loading" type="submit"></v-btn>
                            </v-col>
                        </v-card>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
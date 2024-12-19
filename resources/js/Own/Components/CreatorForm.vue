<script setup>
import { useRoute, useRouter } from 'vue-router'
import { storeCreator, getCreator, updateCreator } from '@/api'
import { onMounted, ref, defineEmits } from 'vue'

const props = defineProps({
    state: {
        type: String,
        required: true,
        default: 'Create',
    }
})

const form = ref({
    name: '',
})
const router = useRouter()
const route = useRoute()
const loading = ref()
const errorMessages = ref({})
const emit = defineEmits()

const loadCreator = async () => {
    const { data } = await getCreator(route.params.id)
    form.value = data
}

onMounted(() => {
    if (route.params.id) {
        loadCreator()
        //update.value = true;
    }
})

const saveCreator = async () => {
    loading.value = true;

    if (props.state == 'Update') {
        try {
            await updateCreator(route.params.id, form.value)

            router.push({ name: 'creators' });
        } catch (error) {
            if (error.response.status == 422) {
                errorMessages.value = error.response.data.errors
                console.error('Error al editar al creador:', error)
                loading.value = false;

                return errorMessages
            }
        }
    } if (props.state == 'Create') {
        try {
            await storeCreator(form.value)

            router.push({ name: 'creators' });
        } catch (error) {
            if (error.response.status == 422) {
                errorMessages.value = error.response.data.errors
                console.error('Error al guardar al creador:', error)
                loading.value = false;

                return errorMessages
            }
        }
    } if (props.state == 'inGame') {
        try {
            await storeCreator(form.value)
            form.value.name = ''
            loading.value = false;

            emit('saved');
        } catch (error) {
            if (error.response.status == 422) {
                errorMessages.value = error.response.data.errors
                console.error('Error al guardar al creador:', error)
                loading.value = false;

                return errorMessages
            }
        }
    }
};
</script>

<template>
    <form @submit.prevent="saveCreator">
        <v-card class="mx-auto pa-12 pb-8" elevation="8" max-width="448" rounded="lg">
            <div class="text-subtitle-1 text-medium-emphasis">Nombre</div>
            <v-text-field id="name" density="compact" placeholder="Nombre" variant="outlined"
                v-model="form.name" :error-messages="errorMessages.name"></v-text-field>

            <v-col class="text-end ma-0 pa-0">
                <v-btn class="mb-6" color="indigo-darken-4" size="large" :disabled="loading" type="submit">
                    {{ state=='Update' ? 'Actualizar' : 'Añadir' }}
                </v-btn>
            </v-col>
        </v-card>
    </form>
</template>
<script setup>
import { useRoute } from 'vue-router'
import { storeComment } from '@/api'
import { ref, defineEmits } from 'vue'

const props = defineProps({
    state: {
        type: String,
        required: true,
        default: 'Create',
    }
})

const form = ref({
    content: '',
})
const route = useRoute()
const loading = ref()
// const errorMessages = ref({})
const emit = defineEmits()

const saveComment = async () => {
    loading.value = true;

    // if (props.state == 'Update') {
    //     try {
    //         await updateCreator(route.params.id, form.value)

    //         router.push({ name: 'creators' });
    //     } catch (error) {
    //         if (error.response.status == 422) {
    //             errorMessages.value = error.response.data.errors
    //             console.error('Error al editar al creador:', error)
    //             loading.value = false;

    //             return errorMessages
    //         }
    //     }
    // } 
    if (props.state == 'Create') {
        try {
            await storeComment(route.params.id, form.value)

            form.value.content = '';
            emit('submitComment');
        } catch (error) {
            // if (error.response.status == 422) {
            //     errorMessages.value = error.response.data.errors
            //     console.error('Error al subir el comentario:', error)
            //     loading.value = false;

            //     return errorMessages
            // }
            console.error('Error al subir el comentario:', error)
        }
    }
};
</script>

<template>
    <form @submit.prevent="saveComment">
        <div>
            <v-textarea v-model="form.content" label="Agrega un comentario" outlined></v-textarea>
            <v-btn type="submit" text="Comentar"></v-btn>
        </div>
    </form>
</template>
<script setup>
import axios from 'axios';
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const form = ref({
    email: '',
    password: '',
})
const router = useRouter()
const visible = ref(false)
const errorMessages = ref({})

const doLogin = async () => {
    try {
        const response = await axios.post('/api/login', form.value)

        router.push({ name: 'home' })
        const token = response.data.token;
        localStorage.setItem('token', token)
    } catch (error) {
        if (error.response.status == 422) {
            errorMessages.value = error.response.data.errors
            console.error('Error al intentar iniciar sesión:', error)

            return errorMessages
        }
    }
}
</script>

<template>
    <form @submit.prevent="doLogin">
        <div>
            <v-img class="mx-auto my-6" max-width="228"
                src="https://cdn.vuetifyjs.com/docs/images/logos/vuetify-logo-v3-slim-text-light.svg"></v-img>

            <v-card class="mx-auto pa-12 pb-8" elevation="8" max-width="448" rounded="lg">
                <div class="text-subtitle-1 text-medium-emphasis">Correo Electrónico</div>

                <v-text-field v-model="form.email" density="compact" placeholder="Correo electrónico"
                    prepend-inner-icon="mdi-email-outline" variant="outlined"
                    :error-messages="errorMessages.email"></v-text-field>

                <div class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between">
                    Contraseña
                </div>

                <v-text-field v-model="form.password" :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
                    :type="visible ? 'text' : 'password'" density="compact" placeholder="Escriba su Contraseña"
                    prepend-inner-icon="mdi-lock-outline" variant="outlined" @click:append-inner="visible = !visible"
                    :error-messages="errorMessages.password"></v-text-field>

                <v-btn class="mb-8" color="blue" size="large" variant="tonal" type="submit" block>
                    Iniciar Sesión
                </v-btn>

                <v-card-text class="text-center">
                    ¿No tienes una cuenta?
                    <a class="text-blue text-decoration-none" href="#" rel="noopener noreferrer" target="_blank">
                        Registrate<v-icon icon="mdi-chevron-right"></v-icon>
                    </a>
                </v-card-text>
            </v-card>
        </div>
    </form>
</template>
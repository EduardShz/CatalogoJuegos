<script setup>
import axios from 'axios';
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const form = ref({
    name: '',
    username: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
})
const router = useRouter()
const visible = ref(false)
const visible2 = ref(false)
const errorMessages = ref({})

const doRegister = async () => {
    try {
        const response = await axios.post('/api/register', form.value)

        router.push({ name: 'home' })
        const token = response.data.token;
        localStorage.setItem('token', token)
    } catch (error) {
        if (error.response.status == 422) {
            errorMessages.value = error.response.data.errors
            console.error('Error al intentar registrarse:', error)

            return errorMessages
        }
    }
}
</script>

<template>
    <form @submit.prevent="doRegister">
        <div>
            <v-img class="mx-auto my-6" max-width="228"
                src="https://cdn.vuetifyjs.com/docs/images/logos/vuetify-logo-v3-slim-text-light.svg"></v-img>

            <v-card class="mx-auto pa-12 pb-8" elevation="8" max-width="500" rounded="lg">
                <div class="text-subtitle-1 text-medium-emphasis">Nombre</div>

                <v-text-field v-model="form.name" density="compact" placeholder="Nombre"
                    prepend-inner-icon="mdi-account-outline" variant="outlined"
                    :error-messages="errorMessages.name" autocomplete="name"></v-text-field>

                <div class="text-subtitle-1 text-medium-emphasis">Username</div>

                <v-text-field v-model="form.username" density="compact" placeholder="Username"
                    prepend-inner-icon="mdi-account" variant="outlined"
                    :error-messages="errorMessages.username"></v-text-field>

                <div class="text-subtitle-1 text-medium-emphasis">Correo Electrónico</div>

                <v-text-field v-model="form.email" density="compact" placeholder="Correo electrónico"
                    prepend-inner-icon="mdi-email-outline" variant="outlined" autocomplete="email"
                    :error-messages="errorMessages.email"></v-text-field>

                <div class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between">
                    Contraseña
                </div>

                <v-text-field v-model="form.password" :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
                    :type="visible ? 'text' : 'password'" density="compact" placeholder="Escribir Contraseña"
                    prepend-inner-icon="mdi-lock-outline" variant="outlined" @click:append-inner="visible = !visible"
                    :error-messages="errorMessages.password"></v-text-field>

                <div class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between">
                    Confirmar Contraseña
                </div>

                <v-text-field v-model="form.password_confirmation" :append-inner-icon="visible2 ? 'mdi-eye-off' : 'mdi-eye'"
                    :type="visible2 ? 'text' : 'password'" density="compact" placeholder="Confirmar Contraseña"
                    prepend-inner-icon="mdi-lock-outline" variant="outlined" @click:append-inner="visible2 = !visible2"
                    :error-messages="errorMessages.password_confirmation"></v-text-field>

                <v-btn class="mb-8" color="blue" size="large" variant="tonal" type="submit" block>
                    Registrarse
                </v-btn>

                <v-card-text class="text-center">
                    ¿Ya tienes una cuenta?
                    <v-btn append-icon="mdi-chevron-right" color="blue" class="pa-0 text-none" :to="{ name: 'login' }"
                        variant="plain">Inicia Sesión</v-btn>
                </v-card-text>
            </v-card>
        </div>
    </form>
</template>
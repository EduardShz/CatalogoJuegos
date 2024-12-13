<script setup>
import axios from 'axios';
import { ref, reactive } from 'vue'

axios.defaults.headers.common['X-CSRF-TOKEN'] = document.head.querySelector('meta[name="csrf-token"]').content;

const form = reactive({
    email: '',
    password: '',
    visible: false,
    loading: false,
})

const users = ref([])

const login = async () => {
  form.loading = true;
  const response = '';

  try { 
    const response = await axios.post('/loginusers', {
      email: form.email,
      password: form.password,
    });

    if (response.data) {
      console.log('Datos del servidor:', response.data);
    } else {
      console.error('La respuesta no contiene datos.');
    }
    window.location.href = '/inicio';
  } catch (error) {
    console.error('Error en la solicitud:', error.response?.data || error.message);
    form.loading = false;
  }
};
</script>

<template>
    <div>
      <v-img
        class="mx-auto my-6"
        max-width="228"
        src="https://cdn.vuetifyjs.com/docs/images/logos/vuetify-logo-v3-slim-text-light.svg"
      ></v-img>
        <form @submit.prevent="login">
            <p class="text-h3 font-weight-bold text-center mb-6">Inicio de Sesión</p>
            
            <v-card
                class="mx-auto pa-12 pb-8"
                elevation="8"
                max-width="448"
                rounded="lg"
            >
                <div class="text-subtitle-1 text-medium-emphasis">Email</div>
        
                <v-text-field
                    id="email"
                    v-model="form.email"
                    density="compact"
                    placeholder="Correo electrónico"
                    prepend-inner-icon="mdi-email-outline"
                    variant="outlined"
                ></v-text-field>
        
                <div class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between">
                Contraseña
                </div>
        
                <v-text-field
                    v-model="form.password"
                    :append-inner-icon="form.visible ? 'mdi-eye-off' : 'mdi-eye'"
                    :type="form.visible ? 'text' : 'password'"
                    density="compact"
                    placeholder="Escriba su contraseña"
                    prepend-inner-icon="mdi-lock-outline"
                    variant="outlined"
                    @click:append-inner="form.visible = !form.visible"
                ></v-text-field>
        
                <v-btn class="mb-8" color="blue" size="large" variant="tonal" type="submit" block :disabled="form.loading">
                    {{ form.loading ? 'Iniciando Sesión' : 'Iniciar Sesión' }}
                </v-btn>
        
                <v-card-text class="text-center">
                    ¿No tienes una cuenta?
                    <router-link to="/registro" class="text-blue text-decoration-none" rel="noopener noreferrer">
                        Registrate <v-icon icon="mdi-chevron-right"></v-icon>
                    </router-link>    
                </v-card-text>
            </v-card>
        </form>
    </div>
</template>

<style>
.error {
  color: red;
}
</style>
<template>
    Lista de gatos
    <p v-for="gato in gatos" :key="gato.id">
        {{ gato.name }}
    </p>
    <v-btn color="red" @click="loadGatos()">{{ counter }}</v-btn>
    <v-text-field v-model="form.nombre" @keypress.enter="guardar()"></v-text-field>
</template>

<script setup>
import axios from 'axios';
import { onMounted, ref } from 'vue';

const gatos = ref([])
const counter = ref(0)
const form = ref({
    nombre: null
})

const loadGatos = async () => {
    window.location.href = '/registro';  
}

const contar = async () => {
    if (gatos.value.length) {
        gatos.value = []
        return;
    }
    await loadGatos()
}

const guardar = async () => {
    const { data } = await axios.post('/gatos', form.value)

    gatos.value.push(data.data)
}
</script>
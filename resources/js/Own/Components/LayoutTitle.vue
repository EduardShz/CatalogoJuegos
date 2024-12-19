<script setup>
defineProps({
    title: {
        type: String,
    },
});
</script>

<template>
    <v-sheet v-if="title" class="pa-4 mb-4 elevation-1">
        <h1 class="text-h4 font-weight-bold">{{ title }}</h1>
    </v-sheet>
</template>
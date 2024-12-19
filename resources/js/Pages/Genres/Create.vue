<script setup>
import LayoutTitle from '@/Own/Components/LayoutTitle.vue'
import GenreForm from '@/Own/Components/GenreForm.vue'
</script>

<template>
    <LayoutTitle title="Añadir Género" />

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-8">
            <div class="p-2">
                <GenreForm :state="'Create'"/>
            </div>
        </div>
    </div>
</template>
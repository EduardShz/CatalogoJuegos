<script setup>
import LayoutTitle from '@/Own/Components/LayoutTitle.vue'
import CreatorForm from '@/Own/Components/CreatorForm.vue'
</script>

<template>
    <LayoutTitle title="Añadir Creador" />

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-8">
            <div class="p-2">
                <CreatorForm :state="'Create'"/>
            </div>
        </div>
    </div>
</template>
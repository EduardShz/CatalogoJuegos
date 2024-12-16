<template>
    <v-layout>
        <v-main>
            <router-view></router-view>
            <inertia></inertia>
        </v-main>
    </v-layout>
</template>

<script>
export default {
  name: "App",
};
</script>
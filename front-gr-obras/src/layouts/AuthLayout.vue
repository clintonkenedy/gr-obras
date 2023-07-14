
<template>
    <v-app>
        <v-main class="auth-layout">
            <router-view />
        </v-main>
    </v-app>
</template>
<script setup>
</script>
<style lang="scss">
.auth-layout {
    height: 100vh;
    width: 100vw;
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>

<template>
  <q-layout view="hHh lpR fFf">
    <q-page-container class="row auth-layout">
      <router-view />
    </q-page-container>
  </q-layout>
  <!-- <v-app>
        <v-main class="auth-layout">
            <router-view />
        </v-main>
    </v-app> -->
</template>
<script setup></script>
<style lang="scss">
.auth-layout {
  height: 100vh;
  width: 100vw;
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>

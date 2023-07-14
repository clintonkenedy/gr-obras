<template>
  <div class="q-pa-md col responsive">
    <q-card class=" my-card">
      <q-img src="img/login01.jpg" style="height: 200px;" fit="cover">
        <div class="absolute-bottom text-h6">
          LOGIN
        </div>
      </q-img>

      <q-card-section class="q-pa-md">
        <LoginFormComponent @logued="onLogued"></LoginFormComponent>
      </q-card-section>
    </q-card>
  </div>
</template>

<script setup>

import LoginFormComponent from "components/LoginFormComponent.vue"
import { useRouter } from "vue-router";


const router = useRouter()
import { ref } from "vue";



const onLogued = () => {
  router.push({ name: 'Dash' })
}
</script>
<style lang="sass" scoped>
.my-card
  width: 100%
  max-width: 400px

.responsive
  display: flex
  justify-content: center
  align-items: center
</style>


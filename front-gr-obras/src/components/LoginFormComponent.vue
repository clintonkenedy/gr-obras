<template>
  <div class="q-pa-none">

    <q-form @submit="login" @reset="onReset" class="q-gutter-md">
      <q-input dense outlined v-model="formLogin.email" label="Email" type="email"
        :rules="[val => val && val.length > 0 || 'Ingrese un correo valido']" />

      <q-input dense outlined v-model="formLogin.password" label="Contraseña" :type="isPwd ? 'password' : 'text'"
        :rules="[val => val && val.length > 0 || 'Ingrese una contraseña valida']">
        <template v-slot:append>
          <q-icon :name="isPwd ? 'visibility_off' : 'visibility'" class="cursor-pointer" @click="isPwd = !isPwd" />
        </template>
      </q-input>

      <div>
        <q-btn :loading="progress.loading" label="Ingresar" type="submit" color="secondary" />
        <q-btn label="Reset" type="reset" color="secondary" flat class="q-ml-sm" />
      </div>
      <q-banner v-show="alertText" rounded class="bg-secondary text-primary">{{ alertText }}</q-banner>
      <q-banner v-show="errorText" rounded class="bg-negative text-primary">{{ errorText }}</q-banner>
    </q-form>

  </div>
</template>

<script setup>
import { ref } from "vue";
import { useUserStore } from "src/stores/user-store";
import { useQuasar } from "quasar";

const $q = useQuasar();

const emits = defineEmits(["logued"]);
const userStore = useUserStore();
const progress = ref({ loading: false, portentage: 0 })
const alertText = ref(null)
const errorText = ref(null)

const isPwd = ref(true)
const formLogin = ref({
  email: "",
  password: "",
});
const login = async () => {
  progress.value.loading = true

  try {
    const login = await userStore.login(formLogin.value.email, formLogin.value.password)
    console.log(login.data)
    // userStore.setUser(login.data.user)
    emits("logued")
    console.log("login...")
    alertText.value = "Redireccionando ..."
    progress.value.loading = false
    $q.notify({
      position: 'top',
      type: 'positive',
      message: 'Seccion Iniciada con Exito',
      timeout: 1000,
    })



  } catch (e) {
    if (e.response) {
      errorText.value = "Credenciales Inconrrectas"
      console.log(e.response)
      $q.notify({
        position: 'top',
        type: 'negative',
        message: 'Credenciales Inconrrectas'
      })

    } else {
      errorText.value = "No hay Servidor"
      $q.notify({
        position: 'top',
        type: 'negative',
        message: 'No hay Servidor'
      })

    }
    progress.value.loading = false


  }

  // console.log(formLogin.value.email)
}

const onReset = () => {

}

</script>


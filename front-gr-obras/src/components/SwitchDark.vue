<template>
  <q-checkbox v-model="dark" :color="color" :keep-color="!dark" @update:model-value="darkMode" size="lg" checked-icon="light_mode"
    unchecked-icon="mdi-circle-slice-4" >
    <q-tooltip :class="$q.dark.isActive ? 'bg-primary text-secondary' : 'bg-primary text-white'"
      anchor="bottom middle" self="center middle">{{ $q.dark.isActive ? 'Modo Luz' : 'Modo Oscuro' }}
    </q-tooltip>
  </q-checkbox>
</template>

<script setup>
import { useQuasar } from "quasar";
import { ref } from "vue";


const $q = useQuasar()
const dark = ref(true);
const color = ref('white');

if ($q.dark.isActive) {
  $q.dark.set(true);
} else {
  $q.dark.set(false);
  dark.value = false;
}
const darkMode = (v) => {
  $q.dark.set(v);
  color.value = 'white'
}

</script>
<style></style>

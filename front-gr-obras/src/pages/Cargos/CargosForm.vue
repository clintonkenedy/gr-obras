<template>
  <q-input outlined borderless dense debounce="300" v-model="form.nombre" label="Nombre" :error-message="errors.nombre"
      :error="errors.nombre != null" />
</template>

<script setup>
import { ref, onMounted } from 'vue';

const emits = defineEmits(['save']);

//Estados reactivos
const form = ref({
  id: null,
  nombre: null
});
const errors = ref({});

//onMounted
onMounted( () => {
  reset();
})

//Métodos
function setValue(row) {
  form.value = row;
}

function setErrors(row){
  errors.value.nombre = row.nombre[0];
}

function save() {
  emits('save', form.value);
}

function reset() {
  form.value.id = null;
  form.value.nombre = null;
  errors.value = {};
}

//Expose
defineExpose({
  setValue,
  setErrors,
  save,
  reset
});
</script>

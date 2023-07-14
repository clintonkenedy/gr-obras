<template>
    <q-input outlined borderless dense debounce="300" v-model="form.nombre" label="Nombre" error-message="Requerido"
        :error="true" />
</template>
  
<script setup>
import { ref, defineExpose } from 'vue';

//Estados reactivos
const form = ref({
    id: null,
    nombre: null
});
const errors = ref({});

//Métodos
function setValue(row) {
    form.value = row;
}

function save() {
    try {

    } catch (error) {
        errors.value = error;
    }
}

//Expose
defineExpose({
    setValue,
    save
});
</script>
  
<template>
    <q-input outlined borderless dense debounce="300" v-model="form.nombre" label="Nombre" error-message="Requerido"
        :error="true" />
</template>
  
<script setup>
import { ref } from 'vue';

const emits = defineEmits(['save']);
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
    emits('save', form.value);
    // try {

    // } catch (error) {
    //     errors.value = error;
    // }
}

function reset() {
    console.log("cesar");
}
//Expose
defineExpose({
    setValue,
    save,
    reset
});
</script>
  
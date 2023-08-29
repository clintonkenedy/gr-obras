<template>
  <q-dialog v-model="show" @hide="reset()" persistent>
    <q-card style="width: 100%; max-width: 700px">
      <q-card-section>
        <div class="text-h6">Profesión</div>
      </q-card-section>

      <q-separator />

      <q-card-section>
        <q-input outlined borderless dense debounce="300" v-model="form.nombre" label="Nombre"
          :error-message="errors.nombre" :error="errors.nombre != null" />
      </q-card-section>

      <q-separator />

      <q-card-actions align="right">
        <q-btn flat label="Cancelar" color="gray" v-close-popup />
        <q-btn flat label="Guardar" color="primary" @click="save" :loading="loading" />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>
<script setup>
import { ref, onMounted } from "vue";

const emits = defineEmits(["save"]);

//Estados reactivos
const form = ref({
  id: null,
  nombre: null
});
const errors = ref({});
const show = ref(false);
const loading = ref(false);

//onMounted
onMounted(() => {
  reset();
})

//Métodos
function setValue(values) {
  form.value = values;
}

function save() {
  emits("save");
}

function reset() {
  form.value = {}
  errors.value = {};
}

function setErrors(row) {
  errors.value.nombre = row.nombre ? row.nombre[0] : null;
}

defineExpose({
  show,
  save,
  loading,
  form,
  reset,
  setValue,
  setErrors
});
</script>

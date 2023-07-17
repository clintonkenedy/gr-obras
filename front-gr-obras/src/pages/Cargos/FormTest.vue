<template>

  <q-dialog v-model="show" @hide="reset()" persistent>
    <q-card class="my-card">
      <q-card-section>
        <div class="text-h6">Cargo</div>
      </q-card-section>

      <q-separator />

      <q-card-section>
        <q-input
          outlined
          borderless
          dense
          debounce="300"
          v-model="form.nombre"
          label="Nombre"
          :error-message="errors.nombre"
          :error="errors.nombre != null"
        />
      </q-card-section>
      <q-separator />

      <q-card-actions align="right">
        <q-btn flat label="Cancelar" color="gray" v-close-popup />
        <q-btn
          flat
          label="Guardar"
          color="primary"
          @click="save"
          :loading="loading"
        />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>
<script setup>
import { ref,onMounted } from "vue";

const emits = defineEmits(["save"]);

const show = ref(false);
const loading = ref(false);
//Estados reactivos
const form = ref({
  id: null,
  nombre: null,
});
const errors = ref({});

//onMounted
onMounted( () => {
  reset();
})

function setValue(values) {
    form.value = values;
}
function save() {
  emits("save");
}
function reset() {
  form.value={}
  errors.value = {};
}
function setErrors(row){
    errors.value.nombre = row.nombre[0];
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
<style lang="sass" scoped>
.my-card
  width: 100%
  max-width: 80vw
</style>

<template>
  <q-dialog v-model="show" @hide="reset()" persistent>
    <q-card class="my-card">
      <q-card-section>
        <div class="text-h6">Cargo</div>
      </q-card-section>

      <q-separator />

      <q-card-section class="q-gutter-xs">
        <q-input
          outlined
          borderless
          dense
          debounce="300"
          v-model="form.name"
          label="Nombre"
          :error="errors.name != null"
        >
          <template v-slot:error>
            <template v-for="(value, key) in errors.name" :key="key">
              *{{ value }}
            </template>
          </template>
        </q-input>

        <q-input
          outlined
          borderless
          dense
          debounce="300"
          v-model="form.description"
          label="Descripcion"
          :error="errors.description != null"
        >
          <template v-slot:error>
            <template v-for="(value, key) in errors.description" :key="key">
              *{{ value }}
            </template>
          </template>
        </q-input>
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
import { ref, onMounted } from "vue";

const emits = defineEmits(["save"]);

const show = ref(false);
const loading = ref(false);
//Estados reactivos
const form = ref({
  id: null,
  name: null,
  description: null,
});
const errors = ref();

//onMounted
onMounted(() => {
  reset();
});

function setValue(values) {
  form.value = values;
}
function save() {
  emits("save");
}
function reset() {
  // form.value.id= null
  // form.value.name=null
  // form.value.description=null
  form.value = {};
  errors.value = {};
  // errors.value.name = null ;
  // errors.value.description = null ;
}

defineExpose({
  show,
  save,
  loading,
  form,
  reset,
  setValue,
  errors,
});
</script>
<style lang="sass" scoped>
.my-card
  width: 100%
  max-width: 80vw
</style>

<template>
  <q-dialog v-model="show" @hide="reset()" persistent>
    <q-card class="my-card">
      <q-card-section>
        <div class="text-h6">Avances</div>
      </q-card-section>

      <q-separator />

      <q-card-section>

        <div class="q-pa-md">

          <div class="row">
            <div class="col-sm-4 col-xs-12">
              <q-select class="q-mx-sm" borderless dense v-model="form.tipo" :options="['fisica', 'financiera']"
                label="Estado" :error-message="errors.tipo" :error="errors.tipo != null" />
              <!-- <q-input class="q-mx-sm" outlined borderless dense debounce="300" v-model="form.cui" label="CUI"
                :error-message="errors.nombre" :error="errors.nombre != null" /> -->
            </div>
            <div class="col-sm-4 col-xs-12 q-py-xs">
              <q-input class="q-mx-sm" type="date" outlined borderless dense debounce="300" v-model="form.fec"
                label="Fecha" :error-message="errors.fec" :error="errors.fec != null" />
            </div>
            <div class="col-sm-4 col-xs-12 q-py-xs">
              <q-input class="q-mx-sm" outlined borderless dense debounce="300" v-model="form.estado" label="Estado"
                :error-message="errors.estado" :error="errors.estado != null" />
            </div>
          </div>

          <div class="row">
            <div class="col">
              <q-input class="q-mx-sm" outlined borderless dense debounce="300" v-model="form.obra_id" label="Obra"
                :error-message="errors.obra_id" :error="errors.obra_id != null" />
            </div>
          </div>

        </div>

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

const show = ref(false);
const loading = ref(false);
//Estados reactivos
const form = ref({});
const errors = ref({});

//onMounted
onMounted(() => {
  reset();
})

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

<template>
  <q-dialog v-model="show" @hide="reset()" persistent>
    <q-card class="my-card" style="width: 400px">
      <q-card-section>
        <div class="text-h6">Archivos</div>
      </q-card-section>

      <q-separator />

      <q-card-section>

        <div class="q-pa-md">

          <div class="row">
            <div class="col-sm-12 col-xs-12">
              <q-file class="q-mx-sm" outlined v-model="form.nombre" label="Archivo" borderless dense
                debounce="300" :error-message="errors.nombre" :error="errors.nombre != null">
                <template v-slot:prepend>
                  <q-icon name="attach_file" />
                </template>
              </q-file>
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

<template>
  <q-dialog v-model="show" @hide="reset()" persistent>
    <q-card class="my-card">
      <q-card-section>
        <div class="text-h6">Cronogramas</div>
      </q-card-section>

      <q-separator />

      <q-card-section>

        <div class="q-pa-md">

          <div class="row">
            <div class="col-sm-4 col-xs-12">
              <q-select class="q-mx-sm" borderless dense v-model="form.tipo" :options="['semanal', 'mensual']"
                label="Tipo" :error-message="errors.tipo" :error="errors.tipo != null" />
            </div>
            <div class="col-sm-4 col-xs-12 q-py-xs">
              <q-input class="q-mx-sm" type="date" outlined borderless dense debounce="300" v-model="form.fec_ini"
                label="F. Inicio" :error-message="errors.fec_ini" :error="errors.fec_ini != null" />
            </div>
            <div class="col-sm-4 col-xs-12 q-py-xs">
              <q-input class="q-mx-sm" type="date" outlined borderless dense debounce="300" v-model="form.fec_fin"
                label="F. Fin" :error-message="errors.fec_fin" :error="errors.fec_fin != null" />
            </div>
          </div>

          <div class="row">
            <div class="col-sm-3 col-xs-12">
              <q-input class="q-mx-sm" type="number" step="0.01" outlined borderless dense debounce="300"
                v-model="form.presu_req" label="P. Requerido" :error-message="errors.presu_req"
                :error="errors.presu_req != null" />
            </div>
            <div class="col-sm-3 col-xs-12">
              <q-input class="q-mx-sm" type="number" step="0.01" outlined borderless dense debounce="300"
                v-model="form.num_req" label="Nro. Requerido" :error-message="errors.num_req"
                :error="errors.num_req != null" />
            </div>
            <div class="col-sm-3 col-xs-12">
              <q-input class="q-mx-sm" type="number" step="0.01" outlined borderless dense debounce="300"
                v-model="form.porcentaje" label="Procentaje (%)" :error-message="errors.porcentaje"
                :error="errors.porcentaje != null" />
            </div>
            <div class="col-sm-3 col-xs-12">
              <q-input class="q-mx-sm" outlined borderless dense debounce="300" v-model="form.obra_id" label="Obra"
                :error-message="errors.obra_id" :error="errors.obra_id != null" />
            </div>
          </div>

          <div class="row">
            <div class="col-sm-4 col-xs-12">
              <q-input class="q-mx-sm" type="number" step="0.01" outlined borderless dense debounce="300"
                v-model="form.monto_adqui" label="M. Adquirido" :error-message="errors.monto_adqui"
                :error="errors.monto_adqui != null" />
            </div>
            <div class="col-sm-4 col-xs-12">
              <q-input class="q-mx-sm" type="number" step="0.01" outlined borderless dense debounce="300"
                v-model="form.monto_proceso" label="M. Proceso" :error-message="errors.monto_proceso"
                :error="errors.monto_proceso != null" />
            </div>
            <div class="col-sm-4 col-xs-12">
              <q-input class="q-mx-sm" type="number" step="0.01" outlined borderless dense debounce="300"
                v-model="form.monto_total" label="Monto Total" :error-message="errors.monto_total"
                :error="errors.monto_total != null" />
            </div>
          </div>

          <div class="row">
            <div class="col-sm-6 col-xs-12">
              <q-file class="q-mx-sm" outlined v-model="form.arch_cronograma" label="A. Cronograma" borderless dense
                debounce="300">
                <template v-slot:prepend>
                  <q-icon name="attach_file" />
                </template>
              </q-file>
            </div>
            <div class="col-sm-6 col-xs-12">
              <q-file class="q-mx-sm" outlined v-model="form.requerimientos" label="A. Requerimientos" borderless
                dense debounce="300">
                <template v-slot:prepend>
                  <q-icon name="attach_file" />
                </template>
              </q-file>
            </div>
          </div>

          <div class="row q-mt-md">
            <div class="col-sm-6 col-xs-12 q-mb-sm">
              <ButtonDescargarArchivo v-show="edit && form.arch_cronograma" :form="form.arch_cronograma" label="A. Cronograma"/>
            </div>
            <div class="col-sm-6 col-xs-12">
              <ButtonDescargarArchivo v-show="edit && form.requerimientos" :form="form.requerimientos" label="A. Requerimientos"/>
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
import ButtonDescargarArchivo from "src/components/ButtonDescargarArchivo.vue";

const emits = defineEmits(["save"]);

const show = ref(false);
const loading = ref(false);
//Estados reactivos
const form = ref({});
const errors = ref({});
const edit = ref(false);

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
  form.value = {};
  edit.value = false;
  errors.value = {};
}
function setErrors(row) {
  errors.value = row;
}

defineExpose({
  show,
  save,
  loading,
  form,
  reset,
  setValue,
  setErrors,
  edit
});
</script>
<style lang="sass" scoped>
.my-card
  width: 100%
  max-width: 80vw
</style>

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
              <q-select class="q-mx-sm" borderless dense v-model="form.tipo" :options="['físico', 'financiera']"
                label="Tipo" :error-message="errors.tipo" :error="errors.tipo != null" />
            </div>
            <div class="col-sm-4 col-xs-12 q-py-xs">
              <q-input class="q-mx-sm" type="date" outlined borderless dense debounce="300" v-model="form.fecha"
                label="Fecha" :error-message="errors.fecha" :error="errors.fecha != null" />
            </div>
            <div class="col-sm-4 col-xs-12 q-py-xs">
              <q-select class="q-mx-sm" borderless dense v-model="form.estado" :options="['en proceso', 'finalizado']"
                label="Estado" :error-message="errors.estado" :error="errors.estado != null" />
            </div>
          </div>

          <div class="row">
            <div class="col-sm-3 col-xs-12 q-py-xs" v-show="form.tipo == 'físico'">
              <q-input class="q-mx-sm" type="number" outlined borderless dense debounce="300"
                v-model="form.avance_fisico_km" label="Kilómetros" :error-message="errors.avance_fisico_km"
                :error="errors.avance_fisico_km != null" />
            </div>
            <div class="col-sm-3 col-xs-12 q-py-xs" v-show="form.tipo == 'físico'">
              <q-input class="q-mx-sm" type="number" outlined borderless dense debounce="300"
                v-model="form.avance_fisico_npisos" label="Nº Pisos" :error-message="errors.avance_fisico_npisos"
                :error="errors.avance_fisico_npisos != null" />
            </div>
            <div class="col-sm-3 col-xs-12 q-py-xs" v-show="form.tipo == 'físico'">
              <q-input class="q-mx-sm" type="number" outlined borderless dense debounce="300"
                v-model="form.avance_fisico_metros" label="Metros" :error-message="errors.avance_fisico_metros"
                :error="errors.avance_fisico_metros != null" />
            </div>
            <div v-show="form.tipo != 'físico'" class="col-sm-12 q-py-xs">
              <q-input class="q-mx-sm" type="number" outlined borderless dense debounce="300"
                v-model="form.avance_financiero" label="A. Financiero" :error-message="errors.avance_financiero"
                :error="errors.avance_financiero != null" />
            </div>
          </div>

          <div class="row">
            <div class="col-sm-6 col-xs-12 q-py-xs">
              <SelectObra class="q-mx-sm" ref="obraSelectRef" @selectedItem="updateObra($event)" :error-message="errors.obra_id"
            :error="errors.obra_id != null" />
              <!-- <q-input class="q-mx-sm" outlined borderless dense debounce="300" v-model="form.obra_id" label="Obra"
                :error-message="errors.obra_id" :error="errors.obra_id != null" /> -->
            </div>
            <div class="col-sm-6 col-xs-12 q-py-xs">
              <SelectCronograma class="q-mx-sm" ref="cronogramaSelectRef" @selectedItem="updateCronograma($event)" :error-message="errors.cronograma_id"
            :error="errors.cronograma_id != null" />
              <!-- <q-input class="q-mx-sm" outlined borderless dense debounce="300" v-model="form.cronograma_id"
                label="Cronograma" :error-message="errors.cronograma_id" :error="errors.cronograma_id != null" /> -->
            </div>
          </div>

          <div class="row">
            <div class="col q-py-xs">
              <q-file v-model="form.files" class="q-mx-sm" dense outlined label="Pick files" filled multiple append />
            </div>
          </div>

          <div class="row" v-show="edit">
            <div class="col q-py-xs">

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
import ArchivosService from "src/services/ArchivosService";
import SelectObra from "src/components/SelectObra.vue";
import SelectCronograma from "src/components/SelectCronograma.vue";
import { useQuasar } from "quasar";
const $q = useQuasar();

const emits = defineEmits(["save", "deleteFile"]);

const show = ref(false);
const loading = ref(false);
//Estados reactivos
const form = ref({});
const errors = ref({});
const edit = ref(false);

const obraSelectRef = ref(null);
const cronogramaSelectRef = ref(null);

//onMounted
onMounted(() => {
  reset();
})

function setValue(values) {
  form.value = {};
  form.value = values;
  obraSelectRef.value.getItem(values.obra_id);
  cronogramaSelectRef.value.getItem(values.obra_id);
}
function save() {
  emits("save");
}
function reset() {
  form.value = {
    tipo: 'físico',
  };
  errors.value = {};
  edit.value = false;
}
function setErrors(row) {
  // errors.value.nombre = row.nombre[0];
}

function updateObra(event) {
  form.value.obra_id = event.id;
}
function updateCronograma(event) {
  form.value.cronograma_id = event.id;
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

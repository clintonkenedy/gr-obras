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
              <q-input class="q-mx-sm" outlined borderless dense debounce="300" v-model="form.obra_id" label="Obra"
                :error-message="errors.obra_id" :error="errors.obra_id != null" />
            </div>
            <div class="col-sm-6 col-xs-12 q-py-xs">
              <q-input class="q-mx-sm" outlined borderless dense debounce="300" v-model="form.cronograma_id"
                label="Cronograma" :error-message="errors.cronograma_id" :error="errors.cronograma_id != null" />
            </div>
          </div>

          <div class="row">
            <div class="col q-py-xs">
              <q-file v-model="form.files" class="q-mx-sm" dense outlined label="Pick files" filled multiple append />
            </div>
          </div>

          <div class="row" v-show="edit">
            <div class="col q-py-xs">
              <q-list bordered class="rounded-borders q-mx-sm">
                <q-item-label header>Archivos cargados</q-item-label>

                <q-item v-for="(archivo, i) in form.archivos" :key="i">
                  <q-item-section avatar top>
                    <q-icon name="attach_file" color="black" size="34px" />
                  </q-item-section>

                  <q-item-section top>
                    <q-item-label lines="1">
                      {{ archivo.nombre }} - {{ archivo.size }}
                      <span class="text-grey-8"><q-icon name="picture_as_pdf" /></span>
                    </q-item-label>
                    <q-item-label caption lines="1">
                      <span class="text-weight-medium">{{ archivo.desc }}</span>
                    </q-item-label>
                    <!-- <q-item-label lines="1" class="q-mt-xs text-body2 text-weight-bold text-primary text-uppercase">
                      <span class="cursor-pointer">Cesar in GitHub </span>
                    </q-item-label> -->
                  </q-item-section>

                  <q-item-section top side>
                    <div class="text-grey-8 q-gutter-sm">
                      <q-btn @click="descargar(archivo)" size="11px" dense round icon="download" color="green" outline />
                      <q-btn @click="eliminar(archivo.id)" size="11px" dense round icon="delete" color="red" outline />
                    </div>
                  </q-item-section>
                </q-item>


              </q-list>
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
import { useQuasar } from "quasar";
const $q = useQuasar();

const emits = defineEmits(["save", "deleteFile"]);

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
  form.value = {};
  form.value = values;
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

const descargar = (archivo) => {
  if (['jpg', 'jpeg', 'png', 'gif', 'bmp', 'pdf'].includes(archivo.extension)) {
    window.open(archivo.url, '_blank')
  } else {
    window.location.href = archivo.url;
  }
};
async function eliminar(id) {
  $q.dialog({
    title: "Confirm",
    message:
      "¿Estas seguro de eliminar este registro? Este proceso es irreversible.",
    cancel: true,
    persistent: true,
  }).onOk(async () => {
    await ArchivosService.delete(id);
    $q.notify({
      type: 'positive',
      message: 'Eliminado con Exito.',
      position: 'top-right',
      progress: true,
      timeout: 1000,
    })
    emits("deleteFile", form.value.id);
  });
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

<template>
  <q-dialog v-model="show" @hide="reset()" persistent>
    <q-card class="my-card">
      <q-card-section>
        <div class="text-h6">Obras</div>
      </q-card-section>

      <q-separator />

      <q-card-section>

        <div class="q-pa-md">

          <div class="row">
            <div class="col-sm-4 col-xs-12">
              <q-input class="q-mx-sm" outlined borderless dense debounce="300" v-model="form.cui" label="CUI"
                :error-message="errors.cui" :error="errors.cui != null" />
            </div>
            <div class="col-sm-4 col-xs-12">
              <q-input class="q-mx-sm" outlined borderless dense debounce="300" v-model="form.meta" label="Meta"
                :error-message="errors.meta" :error="errors.meta != null" />
            </div>
            <div class="col-sm-4 col-xs-12">
              <q-input class="q-mx-sm" outlined borderless dense debounce="300" v-model="form.sector" label="Sector"
                :error-message="errors.sector" :error="errors.sector != null" />
            </div>
          </div>

          <div class="row">
            <div class="col">
              <q-input class="q-mx-sm" outlined borderless dense debounce="300" v-model="form.nombre_proyecto"
                label="N. Proyecto" :error-message="errors.nombre_proyecto" :error="errors.nombre_proyecto != null" />
            </div>
          </div>

          <div class="row">
            <div class="col-sm-3 col-xs-12 q-py-xs">
              <q-select class="q-mx-sm" outlined borderless dense v-model="form.estado_obra"
                :options="['en ejecución', 'pendiente', 'suspendido', 'finalizado']" label="Estado" :error-message="errors.estado_obra"
                :error="errors.estado_obra != null" />
            </div>
            <div class="col-sm-3 col-xs-12 q-py-xs">
              <q-input class="q-mx-sm" outlined borderless dense debounce="300" v-model="form.dura_dias"
                label="Duración en Días" :error-message="errors.dura_dias" :error="errors.dura_dias != null" />
            </div>
            <div class="col-sm-3 col-xs-12 q-py-xs">
              <q-input class="q-mx-sm" type="date" outlined borderless dense debounce="300" v-model="form.fec_ini"
                label="F. Inicio" :error-message="errors.fec_ini" :error="errors.fec_ini != null" />
            </div>
            <div class="col-sm-3 col-xs-12 q-py-xs">
              <q-input class="q-mx-sm" type="date" outlined borderless dense debounce="300" v-model="form.fec_fin"
                label="F. Fin" :error-message="errors.fec_fin" :error="errors.fec_fin != null" />
            </div>
          </div>

          <div class="row q-mb-md">
            <SelectUbigeo ref="ubigeoSelectRef" :ubigeo_cod="form.ubigeo_cod" @selectedItem="updateUbigeo($event)">
            </SelectUbigeo>
          </div>

          <div class="row">
            <div class="col-sm-4 col-xs-12">
              <q-input class="q-mx-sm" outlined borderless dense debounce="300" v-model="form.cordinador_id"
                label="Cordinador" :error-message="errors.cordinador_id" :error="errors.cordinador_id != null" />
            </div>
            <div class="col-sm-4 col-xs-12">
              <q-input class="q-mx-sm" outlined borderless dense debounce="300" v-model="form.residente_id"
                label="Residente" :error-message="errors.residente_id" :error="errors.residente_id != null" />
            </div>
            <div class="col-sm-4 col-xs-12">
              <q-input class="q-mx-sm" outlined borderless dense debounce="300" v-model="form.economista_id"
                label="Economista" :error-message="errors.economista_id" :error="errors.economista_id != null" />
            </div>
          </div>

          <div class="row">
            <div class="col-sm-6 col-xs-12">
              <q-file class="q-mx-sm" outlined v-model="form.resolucion" label="A. Resolución" borderless dense
                debounce="300">
                <template v-slot:prepend>
                  <q-icon name="attach_file" />
                </template>
              </q-file>
            </div>
            <div class="col-sm-6 col-xs-12">
              <q-file class="q-mx-sm" outlined v-model="form.kmz" label="A. kmz" borderless dense debounce="300">
                <template v-slot:prepend>
                  <q-icon name="attach_file" />
                </template>
              </q-file>
            </div>
          </div>

          <div class="row" v-show="edit">
            <div class="col q-py-sm">
              <ListArchivos :files="form.files" @deleteFile="id => emits('deleteFile', form.id)" />
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
import SelectUbigeo from "src/components/SelectUbigeo.vue";
// import ButtonDescargarArchivo from "src/components/ButtonDescargarArchivo.vue";
import ListArchivos from "src/components/ListArchivos.vue";

const emits = defineEmits(["save", "deleteFile"]);

const show = ref(false);
const loading = ref(false);
//Estados reactivos
const form = ref({});
const errors = ref({});
const ubigeoSelectRef = ref(null);
const edit = ref(false);

//onMounted
onMounted(() => {
  reset();
})

function setValue(values) {
  form.value = values;
  ubigeoSelectRef.value.getUbigeo(form.value.ubigeo_cod);
}
function save() {
  emits("save");
}
function reset() {
  form.value = {};
  errors.value = {};
  edit.value = false;
}
function setErrors(row) {
  console.log(row);
  // errors.value.nombre = row.nombre[0];
}

// const descargarCronograma = () => {
//   if (['jpg', 'jpeg', 'png', 'gif', 'bmp', 'pdf'].includes(form.value.resolucion.extension)) {
//     window.open(form.value.resolucion.url, '_blank')
//   } else {
//     window.location.href = form.value.resolucion.url;
//   }
// };
// const descargarRequerimientos = () => {
//   if (['jpg', 'jpeg', 'png', 'gif', 'bmp', 'pdf'].includes(form.value.kmz.extension)) {
//     window.open(form.value.kmz.url, '_blank')
//   } else {
//     window.location.href = form.value.kmz.url;
//   }
// };

function updateUbigeo(event) {
  form.value.ubigeo_cod = event;
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

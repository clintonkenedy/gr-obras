<template>
  <q-dialog v-model="show" @hide="reset()" persistent>
    <q-card class="my-card">
      <q-card-section>
        <div class="text-h6">Avances</div>
      </q-card-section>

      <q-separator />

      <q-card-section>
        <div class="row">
          <div class="col-12 col-sm-3">

            <q-list bordered separator>
              <q-item dense>
                <q-item-section>
                  <q-btn class="full-width q-ma-sm" outline color="primary" icon="file_download" label="Plantilla"
                    @click="descargaPlantilla()" />
                </q-item-section>
              </q-item>

              <q-scroll-area style="height: 400px;">
                <q-item v-for="(am, i) in avancemeses" :key="i" dense>
                  <q-item-section>
                    <q-item-label :class="avancemeses.length == i + 1 ? 'q-mx-lg text-green-4' : 'q-mx-lg'">{{ i + 1 }}.
                      {{ am.codigo }}</q-item-label>
                  </q-item-section>
                </q-item>
              </q-scroll-area>
            </q-list>
          </div>
          <div class="col-12 col-sm-9">
            <div class="row">
              <div class="col-12">
                <div class="text-center">NUEVO</div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-sm-6">
                <q-input class="q-ma-sm" type="number" outlined borderless dense debounce="300" v-model="form.anio"
                  label="Año" />
              </div>
              <div class="col-12 col-sm-6">
                <SelectMes class="q-ma-sm" v-model="form.mes" />
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <q-file class="q-ma-sm" outlined v-model="form.bin" label="Archivo de vances (xlsx)" borderless dense
                  debounce="300">
                  <template v-slot:prepend>
                    <q-icon name="attach_file" />
                  </template>
                </q-file>
              </div>
            </div>
            <div class="row">
              <div class="col-12 q-py-sm">
                <q-file v-model="form.files" class="q-mx-sm" dense outlined label="Agregar múltiples archivos" filled
                  multiple append />
              </div>
            </div>
            <q-separator />
            <div class="row">
              <div class="col-12 q-py-sm">
                <div class="text-center q-my-sm">{{ avancemes.codigo }}</div>
                <ListArchivos :files="avancemes.files" @deleteFile="obtenerAvanceMeses()" />
              </div>
            </div>
            <div class="row">
              <div class="col-12 q-py-sm">
                <q-file v-model="form2.files" class="q-mx-sm" dense outlined
                  :label="'Agregar archivos a ' + avancemes.codigo" filled multiple append />
              </div>
            </div>
          </div>
        </div>
      </q-card-section>

      <q-separator />

      <q-card-actions align="right" class="q-ma-sm">
        <q-btn flat label="Cerrar" color="gray" v-close-popup />
        <q-btn flat :label="loading ? '' : 'Guardar'" color="primary" @click="save" :disable="loading">
          <q-spinner-bars v-show="loading" color="primary" size="1em" />
        </q-btn>
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>
<script setup>
import { ref, onMounted } from "vue";
import SelectMes from "src/components/SelectMes.vue";
import AvanceMesService from "src/services/AvanceMesService";
import ArchivosService from "src/services/ArchivosService";
import ListArchivos from "src/components/ListArchivos.vue";

const emits = defineEmits(["save", "deleteFile"]);

const show = ref(false);
const loading = ref(false);
//Estados reactivos
const form = ref({});
const form2 = ref({});
const obra = ref(null);
const avancemeses = ref([]);
const avancemes = ref({});
const errors = ref();

//onMounted
onMounted(() => {
  reset();
})

function setValue(values) {
  // form.value = values;
}
async function save() {
  try {
    if (form.value.mes && form.value.anio && form.value.bin) {
      loading.value = true;
      form.value.obra_id = obra.value.id;
      await AvanceMesService.save(form.value);
    }
    // 
    if (form2.value.files) {
      form2.value.id = avancemes.value.id;
      await AvanceMesService.save(form2.value);
    }
  } catch (e) {
    console.log(e)
  }
  loading.value = false;
  show.value = false;
}
function reset() {
  loading.value = false;
  form.value = {};
  avancemeses.value = [];
  avancemes.value = {};
  form2.value = {};
}
function setErrors(row) {

}

async function obtenerAvanceMeses() {
  try {
    const res = await AvanceMesService.getData({
      params: { obra_id: obra.value?.id }
    });
    avancemeses.value = res;
    avancemes.value = avancemeses.value[avancemeses.value.length - 1];
  } catch (e) {
    console.log(e);
  }
}
async function descargaPlantilla() {
  window.location.href = import.meta.env.VITE_APP_API_URL + 'storage/plantilla-avances.xlsx';
}

defineExpose({
  show,
  save,
  loading,
  form,
  reset,
  setValue,
  setErrors,
  obra,
  obtenerAvanceMeses
});
</script>
<style lang="sass" scoped>
.my-card
  width: 100%
  max-width: 80vw
</style>

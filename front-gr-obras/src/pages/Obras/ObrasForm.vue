<template>
  <q-dialog v-model="show" @hide="reset()" persistent>
    <q-card class="my-card">
      <q-card-section>
        <div class="text-h6">Obras</div>
      </q-card-section>

      <q-separator />

      <q-card-section>
        <q-card flat bordered>
          <q-tabs v-model="tab" inline-label>
            <q-tab name="obra" icon="work" label="Datos de la obra" />
            <q-tab name="presupuesto" icon="newspaper" label="Presupuesto" />
            <q-tab name="gastos" icon="payment" label="Gastos" />
          </q-tabs>

          <q-separator />

          <q-scroll-area style="height: 400px;">
            <q-tab-panels v-model="tab" animated>
              <q-tab-panel name="obra">
                <div>

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
                      <q-input class="q-mx-sm" outlined borderless dense debounce="300" v-model="form.sector"
                        label="Sector" :error-message="errors.sector" :error="errors.sector != null" />
                    </div>
                  </div>

                  <div class="row">
                    <div class="col">
                      <q-input class="q-mx-sm" outlined borderless dense debounce="300" v-model="form.nombre_proyecto"
                        label="Nombre Obra" :error-message="errors.nombre_proyecto"
                        :error="errors.nombre_proyecto != null" />
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-3 col-xs-12 q-py-xs">
                      <q-select class="q-mx-sm" outlined borderless dense v-model="form.estado_obra"
                        :options="['en ejecución', 'pendiente', 'suspendido', 'finalizado']" label="Estado"
                        :error-message="errors.estado_obra" :error="errors.estado_obra != null" />
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
                    <SelectUbigeo ref="ubigeoSelectRef" :ubigeo_cod="form.ubigeo_cod"
                      @selectedItem="updateUbigeo($event)">
                    </SelectUbigeo>
                  </div>

                  <div class="row">
                    <div class="col-sm-4 col-xs-12">
                      <q-input disable class="q-mx-sm" outlined borderless dense debounce="300" v-model="form.cordinador_id"
                        label="Cordinador" :error-message="errors.cordinador_id" :error="errors.cordinador_id != null" />
                    </div>
                    <div class="col-sm-4 col-xs-12">
                      <q-input disable class="q-mx-sm" outlined borderless dense debounce="300" v-model="form.residente_id"
                        label="Residente" :error-message="errors.residente_id" :error="errors.residente_id != null" />
                    </div>
                    <div class="col-sm-4 col-xs-12">
                      <q-input disable class="q-mx-sm" outlined borderless dense debounce="300" v-model="form.economista_id"
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
              </q-tab-panel>

              <q-tab-panel name="presupuesto">
                <div>
                  <div class="row">
                    <div class="col-sm-6 col-xs-12">
                      <q-input class="q-mx-sm" type="number" outlined borderless dense debounce="300" v-model="presupuesto.ppto"
                        label="Presupuesto" :error-message="errors.ppto" :error="errors.ppto != null" />
                    </div>
                    <div class="col-sm-6 col-xs-12">
                      <q-input class="q-mx-sm" type="number" outlined borderless dense debounce="300" v-model="presupuesto.ejecutado"
                        label="Ejecutado" :error-message="errors.ejecutado" :error="errors.ejecutado != null" />
                    </div>
                  </div>
                  <div class="row">
                    <div class="col">
                      <q-input class="q-mx-sm" type="number" outlined borderless dense debounce="300" v-model="presupuesto.saldo"
                        label="Saldo" :error-message="errors.saldo" :error="errors.saldo != null" />
                    </div>
                  </div>
                </div>
              </q-tab-panel>

              <q-tab-panel name="gastos">
                <div>
                  <div class="row">
                    <div class="col-sm-6 col-xs-12">
                      <q-input class="q-mx-sm" type="number" outlined borderless dense debounce="300" v-model="gasto.costo_directo"
                        label="Costo Directo" :error-message="errors.costo_directo"
                        :error="errors.costo_directo != null" />
                    </div>
                    <div class="col-sm-6 col-xs-12">
                      <q-input class="q-mx-sm" type="number" outlined borderless dense debounce="300" v-model="gasto.gastos_generales"
                        label="Gastos Generales" :error-message="errors.gastos_generales"
                        :error="errors.gastos_generales != null" />
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-4 col-xs-12">
                      <q-input class="q-mx-sm" type="number" outlined borderless dense debounce="300" v-model="gasto.gastos_supervision"
                        label="gastos Supervision" :error-message="errors.gastos_supervision"
                        :error="errors.gastos_supervision != null" />
                    </div>
                    <div class="col-sm-4 col-xs-12">
                      <q-input class="q-mx-sm" type="number" outlined borderless dense debounce="300"
                        v-model="gasto.gastos_gest_proyect" label="Gastos Gest. del Proyecto"
                        :error-message="errors.gastos_gest_proyect" :error="errors.gastos_gest_proyect != null" />
                    </div>
                    <div class="col-sm-4 col-xs-12">
                      <q-input class="q-mx-sm" type="number" outlined borderless dense debounce="300" v-model="gasto.gastos_liquidacion"
                        label="Gastos Liquidacion" :error-message="errors.gastos_liquidacion"
                        :error="errors.gastos_liquidacion != null" />
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-4 col-xs-12">
                      <q-input class="q-mx-sm" type="number" outlined borderless dense debounce="300"
                        v-model="gasto.gastos_monito_segui" label="Gastos M. Seguimiento"
                        :error-message="errors.gastos_monito_segui" :error="errors.gastos_monito_segui != null" />
                    </div>
                    <div class="col-sm-4 col-xs-12">
                      <q-input class="q-mx-sm" type="number" outlined borderless dense debounce="300"
                        v-model="gasto.gastos_elabo_expediente" label="Gastos E. de Expediente"
                        :error-message="errors.gastos_elabo_expediente" :error="errors.gastos_elabo_expediente != null" />
                    </div>
                    <div class="col-sm-4 col-xs-12">
                      <q-input class="q-mx-sm" type="number" outlined borderless dense debounce="300"
                        v-model="gasto.gastos_evalu_expediente" label="Gastos E. de Expediente"
                        :error-message="errors.gastos_evalu_expediente" :error="errors.gastos_evalu_expediente != null" />
                    </div>
                  </div>
                </div>
              </q-tab-panel>
            </q-tab-panels>
          </q-scroll-area>

        </q-card>
      </q-card-section>
      <q-separator />

      <q-card-actions align="right" class="q-ma-sm">
        <q-btn flat label="Cerrar" color="gray" v-close-popup />
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
import SelectAdministrativo from "src/components/SelectAdministrativo.vue";

const emits = defineEmits(["save", "deleteFile"]);

const show = ref(false);
const loading = ref(false);
//Estados reactivos
const form = ref({});
const errors = ref();
const ubigeoSelectRef = ref(null);
const edit = ref(false);
const tab = ref('obra');
const presupuesto = ref({});
const gasto = ref({});

//onMounted
onMounted(() => {
  reset();
})

function setValue(values) {
  form.value = values;
  presupuesto.value = values.presupuesto[0];
  gasto.value = values.presupuesto[0].gasto[0];
  ubigeoSelectRef.value.getUbigeo(form.value.ubigeo_cod);
}
function save() {
  form.value.presupuesto = presupuesto.value;
  form.value.gasto = gasto.value;
  emits("save");
}
function reset() {
  tab.value = 'obra';
  form.value = {};
  presupuesto.value = {};
  gasto.value = {};
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

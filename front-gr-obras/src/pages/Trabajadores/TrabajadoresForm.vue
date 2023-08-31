<template>
  <q-dialog v-model="show" @hide="reset()" persistent>
    <q-card style="width: 100%; max-width: 700px">
      <q-card-section>
        <div class="text-h6">Trabajador</div>
      </q-card-section>

      <q-separator />

      <q-card-section>
        <div class="col-12 col-sm-6 q-px-xs">
          <SelectObra ref="obraSelectRef" @selectedItem="updateObra($event)" :error-message="errors.obra_id"
            :error="errors.obra_id != null" />
        </div>
        <div class="row justify-between">
          <div class="col-12 col-sm-6 q-px-xs">
            <SelectPersona ref="personaSelectRef" @selectedItem="updatePersona($event)" :error-message="errors.persona_id"
              :error="errors.persona_id != null" />
          </div>
          <div class="col-12 col-sm-6 q-px-xs">
            <SelectProfesion ref="profesionSelectRef" @selectedItem="updateProfesion($event)"
              :error-message="errors.profesion" :error="errors.profesion != null" />
          </div>
        </div>
        <div class="row justify-between">
          <div class="col-12 col-sm-6 q-px-xs">
            <SelectCargo ref="cargoSelectRef" @selectedItem="updateCargo($event)" :error-message="errors.cargo_id"
              :error="errors.cargo_id != null" />
          </div>
          <div class="col-12 col-sm-6 q-px-xs">
            <q-input outlined borderless dense debounce="300" v-model="form.condicion" label="Condición"
              :error-message="errors.condicion" :error="errors.condicion != null" />
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
import SelectPersona from "src/components/SelectPersona.vue";
import SelectObra from "src/components/SelectObra.vue";
import SelectCargo from "src/components/SelectCargo.vue";
import SelectProfesion from "src/components/SelectProfesion.vue";

const emits = defineEmits(["save"]);

//Estados reactivos
const form = ref({
  id: null,
  profesion: null,
  cargo: null,
  condicion: null,
  obra_id: null,
  persona_id: null,
  cargo_id: null,
});
const errors = ref({});
const show = ref(false);
const loading = ref(false);
const personaSelectRef = ref(null);
const profesionSelectRef = ref(null);
const obraSelectRef = ref(null);
const cargoSelectRef = ref(null);

//onMounted
onMounted(() => {
  reset();
})

//Métodos
function setValue(values) {
  form.value = values;
  obraSelectRef.value.getItem(values.obra_id);
  personaSelectRef.value.getItem(values.persona_id);
  profesionSelectRef.value.getItem(values.profesion_id);
  cargoSelectRef.value.getItem(values.cargo_id);
}

function save() {
  emits("save");
}

function reset() {
  form.value = {}
  errors.value = {};
}

function setErrors(row) {
  errors.value.profesion = row.profesion ? row.profesion[0] : null;
  errors.value.condicion = row.condicion ? row.condicion[0] : null;
  errors.value.obra_id = row.obra_id ? row.obra_id[0] : null;
  errors.value.persona_id = row.persona_id ? row.persona_id[0] : null;
  errors.value.cargo_id = row.cargo_id ? row.cargo_id[0] : null;
}

function updateObra(event) {
  form.value.obra_id = event.id;
}

function updatePersona(event) {
  form.value.persona_id = event.id;
}

function updateProfesion(event) {
  form.value.profesion = event.nombre;
};

function updateCargo(event) {
  form.value.cargo_id = event.id;
  form.value.cargo = event.nombre;
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

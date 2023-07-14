<template>
  <div class="q-px-md q-pt-md">
    <div class="row justify-between">
      <div>
        <p class="text-h4">Profesiones</p>
      </div>
      <div>
        <q-btn color="primary" label="Agregar" icon-right="add" @click="dialog = true" />
      </div>
    </div>
  </div>

  <div class="q-px-md">
    <q-table flat bordered ref="tableRef" color="primary" tabindex="0" title="Lista de Profesiones" :rows="rows"
      :columns="columns" row-key="name" :selected="selected" :pagination="pagination" :filter="filter"
      :loading="loading[2]">
      <template v-slot:loading>
        <q-inner-loading showing color="primary" />
      </template>

      <template v-slot:top-right>
        <q-input outlined borderless dense debounce="300" v-model="filter" placeholder="Buscar">
          <template v-slot:append>
            <q-icon name="search" />
          </template>
        </q-input>
      </template>

      <template v-slot:header="props">
        <q-tr :props="props">
          <q-th v-for="col in props.cols" :key="col.name" :props="props">
            {{ col.label }}
          </q-th>
          <q-th auto-width>
            Acciones
          </q-th>
        </q-tr>
      </template>

      <template v-slot:body="props">
        <q-tr :props="props">
          <q-td v-for="col in props.cols" :key="col.name" :props="props">
            {{ col.value }}
          </q-td>
          <q-td auto-width>
            <q-btn size="sm" outline color="green" round @click="editar(props.row.id)" icon="edit" class="q-mr-xs" />
            <q-btn size="sm" outline color="red" round @click="eliminar(props.row.id)" icon="delete" />
          </q-td>
        </q-tr>
      </template>

    </q-table>
  </div>

  <q-dialog v-model="dialog" persistent>
    <q-card style="width: 700px; max-width: 80vw;">
      <q-card-section>
        <div class="text-h6">Profesión</div>
      </q-card-section>

      <q-separator />

      <q-card-section class="scroll">
        <ProfesionesForm ref="elProfesionesForm" @save="e => save(e)"></ProfesionesForm>
      </q-card-section>

      <q-separator />

      <q-card-actions align="right">
        <q-btn flat label="Cancelar" color="gray" v-close-popup />
        <q-btn flat label="Guardar" @click="elProfesionesForm.save()" color="primary" v-close-popup
          :loading="loading[0]" />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script setup>
import { ref, onMounted, computed, nextTick, toRaw, useAttrs } from 'vue';
import ProfesionesForm from './ProfesionesForm.vue';
import ProfesionesService from '../../services/ProfesionesService.js';
// import useQuasar from 'quasar'
import { useQuasar } from 'quasar'


const $q = useQuasar();
const columns = [
  {
    name: 'id',
    label: 'Id',
    aling: 'center',
    field: row => row.id,
    sortable: true,
  },
  {
    name: 'nombre',
    label: 'Nombre',
    aling: 'center',
    field: row => row.nombre,
    sortable: true
  },
];

const rows = ref([]);
//Estados reactivos
const elProfesionesForm = ref(null);
const dialog = ref(false);
const confirm = ref(false);
const loading = ref([false, false, false]);
const filter = ref("");

//OnMounted
onMounted(() => {
  getData();
});

const getData = async () => {
  loading.value[2] = true
  rows.value = (await ProfesionesService.getData()).data;
  loading.value[2] = false

}

//Métodos
async function save(e) {
  $q.dialog({
    title: 'Confirm',
    message: '¿Estas seguro de eliminar este registro? Este proceso es irreversible.',
    cancel: true,
    persistent: true
  }).onOk(async () => {
    try {
      loading.value[2] = true
      const { id, nombre } = e;
      await ProfesionesService.save({ id, nombre });
      getData();
    } catch (e) {
      console.log(e)
    }
    loading.value[2] = false
  }).onOk(() => {
    // console.log('>>>> second OK catcher')
  }).onCancel(() => {
    // console.log('>>>> Cancel')
  }).onDismiss(() => {
    // console.log('I am triggered on both OK and Cancel')
  })
};

async function editar(id) {
  dialog.value = true;
  const row = await ProfesionesService.get(id);
  elProfesionesForm.value.setValue(row);
};

async function eliminar(id) {
  $q.dialog({
    title: 'Confirm',
    message: '¿Estas seguro de eliminar este registro? Este proceso es irreversible.',
    cancel: true,
    persistent: true
  }).onOk(async () => {
    // console.log('>>>> OK')
    loading.value[2] = true

    await ProfesionesService.delete(id);
    getData();
    loading.value[2] = false

  }).onOk(() => {
    // console.log('>>>> second OK catcher')
  }).onCancel(() => {
    // console.log('>>>> Cancel')
  }).onDismiss(() => {
    // console.log('I am triggered on both OK and Cancel')
  })
}

//DataTable
const tableRef = ref(null);
// const navigationActive = ref(false);
const pagination = ref({});
const selected = ref([]);
</script>

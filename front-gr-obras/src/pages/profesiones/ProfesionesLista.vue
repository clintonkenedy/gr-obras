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
    <q-table flat bordered ref="tableRef" color="primary"  tabindex="0" title="Lista de Profesiones" :rows="rows"
      :columns="columns" row-key="name" :selected="selected" :pagination="pagination" :filter="filter"
      :loading="loading[2]"
      >
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
        <ProfesionesForm ref="elProfesionesForm"></ProfesionesForm>
      </q-card-section>

      <q-separator />

      <q-card-actions align="right">
        <q-btn flat label="Cancelar" color="gray" v-close-popup />
        <q-btn flat label="Guardar" color="primary" v-close-popup :loading="loading[0]" />
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
    const loading = ref([false, false,false]);
    const filter = ref("");

    //OnMounted
    onMounted(() => {
      getData();
    });

    const getData = async ()=>{
      loading.value[2]=true
      rows.value = (await ProfesionesService.getData()).data;
      loading.value[2]=false

    }

    //Métodos
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
      }).onOk(async() => {
        // console.log('>>>> OK')
      loading.value[2]=true

        await ProfesionesService.delete(id);
        getData();
      loading.value[2]=false


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

    // return {
    //   dialog,
    //   confirm,
    //   loading,
    //   editar,
    //   eliminar,

    //   //DataTable
    //   tableRef,
    //   // navigationActive,
    //   filter: ref(""),
    //   selected,
    //   pagination,
    //   columns,
    //   rows,

      // tableClass: computed(() => navigationActive.value === true ? "shadow-2 no-outline" : null),

      // activateNavigation() {
      //   navigationActive.value = true;
      // },

      // deactivateNavigation() {
      //   navigationActive.value = false;
      // },

      // onKey(evt) {
      //   if (navigationActive.value !== true ||
      //     [33, 34, 35, 36, 38, 40].indexOf(evt.keyCode) === -1 ||
      //     tableRef.value === null) {
      //     return;
      //   }
      //   evt.preventDefault();
      //   const { computedRowsNumber, computedRows } = tableRef.value;
      //   if (computedRows.length === 0) {
      //     return;
      //   }
      //   const currentIndex = selected.value.length > 0 ? computedRows.indexOf(toRaw(selected.value[0])) : -1;
      //   const currentPage = pagination.value.page;
      //   const rowsPerPage = pagination.value.rowsPerPage === 0 ? computedRowsNumber : pagination.value.rowsPerPage;
      //   const lastIndex = computedRows.length - 1;
      //   const lastPage = Math.ceil(computedRowsNumber / rowsPerPage);
      //   let index = currentIndex;
      //   let page = currentPage;
      //   switch (evt.keyCode) {
      //     case 36: // Home
      //       page = 1;
      //       index = 0;
      //       break;
      //     case 35: // End
      //       page = lastPage;
      //       index = rowsPerPage - 1;
      //       break;
      //     case 33: // PageUp
      //       page = currentPage <= 1 ? lastPage : currentPage - 1;
      //       if (index < 0) {
      //         index = 0;
      //       }
      //       break;
      //     case 34: // PageDown
      //       page = currentPage >= lastPage ? 1 : currentPage + 1;
      //       if (index < 0) {
      //         index = rowsPerPage - 1;
      //       }
      //       break;
      //     case 38: // ArrowUp
      //       if (currentIndex <= 0) {
      //         page = currentPage <= 1 ? lastPage : currentPage - 1;
      //         index = rowsPerPage - 1;
      //       }
      //       else {
      //         index = currentIndex - 1;
      //       }
      //       break;
      //     case 40: // ArrowDown
      //       if (currentIndex >= lastIndex) {
      //         page = currentPage >= lastPage ? 1 : currentPage + 1;
      //         index = 0;
      //       }
      //       else {
      //         index = currentIndex + 1;
      //       }
      //       break;
      //   }
      //   if (page !== pagination.value.page) {
      //     pagination.value.page = page;
      //     nextTick(() => {
      //       const { computedRows } = tableRef.value;
      //       selected.value = [computedRows[Math.min(index, computedRows.length - 1)]];
      //       tableRef.value.$el.focus();
      //     });
      //   }
      //   else {
      //     selected.value = [computedRows[index]];
      //   }
      // }
    // };


</script>

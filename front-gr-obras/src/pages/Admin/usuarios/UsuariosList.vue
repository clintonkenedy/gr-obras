<template>
  <div class="q-pa-md">
    <q-table
      :rows-per-page-options="[7, 10]"
      flat
      bordered
      ref="tableRef"
      color="primary"
      :rows="rows"
      :columns="columns"
      row-key="id"
      v-model:pagination="pagination"
      :loading="loading"
      :filter="filter"
      binary-state-sort
      @request="onRequest"
    >
      <template v-slot:top-left>
        <q-btn
          color="secondary"
          :disable="loading"
          :label="$q.screen.lt.sm ? '' : 'Agregar'"
          icon-right="add"
          @click="usuariosformRef.show = true"
        />
      </template>

      <template v-slot:top-right>
        <q-input
          outlined
          borderless
          dense
          debounce="500"
          v-model="filter"
          placeholder="Search"
        >
          <template v-slot:append>
            <q-icon name="search" />
          </template>
        </q-input>
      </template>
      <template v-slot:header="props">
        <q-tr :props="props">
          <q-th
            style="
               {
                width: 30%;
              }
            "
            v-for="col in props.cols"
            :key="col.name"
            :props="props"
          >
            {{ col.label }}
          </q-th>
          <q-th auto-width> Acciones </q-th>
        </q-tr>
      </template>

      <template v-slot:body="props">
        <q-tr :props="props">
          <q-td v-for="col in props.cols" :key="col.name" :props="props">
            {{ col.value }}
          </q-td>
          <q-td auto-width>
            <q-btn
              size="sm"
              outline
              color="green"
              round
              @click="editar(props.row.id)"
              icon="edit"
              class="q-mr-xs"
            />
            <q-btn
              size="sm"
              outline
              color="red"
              round
              @click="eliminar(props.row.id)"
              icon="delete"
            />
          </q-td>
        </q-tr>
      </template>
    </q-table>
  </div>
  <UsuariosForm ref="usuariosformRef" @save="save()"></UsuariosForm>
</template>

<script setup>
import { ref, onMounted } from "vue";
import UsuarioService from "src/services/UsuarioService";
import UsuariosForm from "./UsuariosForm.vue";
import { useQuasar } from "quasar";
const $q = useQuasar();
const columns = [
  {
    name: "id",
    label: "Id",
    aling: "center",
    field: (row) => row.id,
    sortable: true,
  },
  {
    name: "name",
    label: "Usuario",
    aling: "center",
    field: (row) => row.name,
    sortable: true,
  },
  {
    name: "email",
    label: "Email",
    aling: "center",
    field: (row) => row.email,
    sortable: true,
  },
];

const tableRef = ref();
const usuariosformRef = ref();
const rows = ref([]);
const filter = ref("");
const loading = ref(false);
const pagination = ref({
  sortBy: "id",
  descending: false,
  page: 1,
  rowsPerPage: 7,
  rowsNumber: 10,
});

async function onRequest(props) {
  const { page, rowsPerPage, sortBy, descending } = props.pagination;
  const filter = props.filter;
  loading.value = true;

  const fetchCount = rowsPerPage === 0 ? 0 : rowsPerPage;
  const order_by = descending ? "-" + sortBy : sortBy;
  const { data, total = 0 } = await UsuarioService.getData({
    params: { rowsPerPage: fetchCount, page, search: filter, order_by },
  });
  console.log(data);
  // clear out existing data and add new
  rows.value.splice(0, rows.value.length, ...data);
  // don't forget to update local pagination object
  !total
    ? (pagination.value.rowsNumber = data.length)
    : (pagination.value.rowsNumber = total);
  pagination.value.page = page;
  pagination.value.rowsPerPage = rowsPerPage;
  pagination.value.sortBy = sortBy;
  pagination.value.descending = descending;
  // ...and turn of loading indicator
  loading.value = false;
}

onMounted(() => {
  tableRef.value.requestServerInteraction();
});

async function save() {
  usuariosformRef.value.loading = true;

  try {
    await UsuarioService.save(usuariosformRef.value.form);
    usuariosformRef.value.loading = false;
    usuariosformRef.value.show = false;
    tableRef.value.requestServerInteraction();
    $q.notify({
      type: "positive",
      message: "Guardado con Exito.",
      position: "top-right",
      progress: true,
      timeout: 1000,
    });
  } catch (e) {
    console.log(e.response.data.errors);
    usuariosformRef.value.errors = e.response.data.errors;
    usuariosformRef.value.loading = false;
  }
}

async function editar(id) {
  usuariosformRef.value.show = true;
  const row = await UsuarioService.get(id);
  usuariosformRef.value.setValue(row);
}

async function eliminar(id) {
  $q.dialog({
    title: "Confirm",
    message:
      "¿Estas seguro de eliminar este registro? Este proceso es irreversible.",
    cancel: true,
    persistent: true,
  }).onOk(async () => {
    await UsuarioService.delete(id);
    tableRef.value.requestServerInteraction();
    $q.notify({
      type: "positive",
      message: "Eliminado con Exito.",
      position: "top-right",
      progress: true,
      timeout: 1000,
    });
  });
}
</script>

<template>
    <div class="q-px-md q-py-md">
        <div class="row justify-between">
            <div>
                <span class="text-h4">Personas</span>
            </div>
        </div>
    </div>

    <div class="q-px-md q-pb-md">
        <q-table dense :rows-per-page-options="[5, 10, 15, 20, 50, 100]" flat bordered ref="tableRef" color="primary"
            :rows="rows" :columns="columns" row-key="id" v-model:pagination="pagination" :loading="loading" :filter="filter"
            binary-state-sort @request="onRequest">
            <template v-slot:top-left>
                <q-btn color="primary" :disable="loading" :label="$q.screen.lt.sm ? '' : 'Agregar'" icon="add"
                    @click="personasformRef.show = true" />
            </template>
            <template v-slot:top-right>
                <q-input outlined borderless dense debounce="500" v-model="filter" placeholder="Buscar">
                    <template v-slot:append>
                        <q-icon name="search" />
                    </template>
                </q-input>
            </template>

            <template v-slot:header="props">
                <q-tr :props="props">
                    <q-th style="{ width: 33%; }" v-for="col in props.cols" :key="col.name" :props="props">
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
                        <q-btn size="sm" outline color="green" round @click="editar(props.row.id)" icon="edit"
                            class="q-mr-xs" />
                        <q-btn size="sm" outline color="red" round @click="eliminar(props.row.id)" icon="delete" />
                    </q-td>
                </q-tr>
            </template>
        </q-table>
    </div>

    <PersonasForm ref="personasformRef" @save="save()"></PersonasForm>
</template>
  
<script setup>
import { ref, onMounted } from "vue";
import { useQuasar } from "quasar";
import PersonasService from "src/services/PersonasService";
import PersonasForm from "./PersonasForm.vue";

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
        name: "tipo_doc",
        label: "Tipo. Doc.",
        aling: "center",
        field: (row) => row.tipo_doc,
        sortable: true,
    },
    {
        name: "num_doc",
        label: "Num. Doc.",
        aling: "center",
        field: (row) => row.num_doc,
        sortable: true,
    },
    {
        name: "nombres",
        label: "Nombres",
        aling: "center",
        field: (row) => row.nombres,
        sortable: true,
    },
    {
        name: "a_paterno",
        label: "A. Paterno",
        aling: "center",
        field: (row) => row.a_paterno,
        sortable: true,
    },
    {
        name: "a_materno",
        label: "A. Materno",
        aling: "center",
        field: (row) => row.a_materno,
        sortable: true,
    },
    {
        name: "email",
        label: "Email",
        aling: "center",
        field: (row) => row.email,
    },
    {
        name: "direccion",
        label: "Dirección",
        aling: "center",
        field: (row) => row.direccion,
    },
    {
        name: "celular",
        label: "Celular",
        aling: "center",
        field: (row) => row.celular,
    },
];

const tableRef = ref();
const personasformRef = ref();
const rows = ref([]);
const filter = ref("");
const loading = ref(false);
const pagination = ref({
    sortBy: "id",
    descending: false,
    page: 1,
    rowsPerPage: 15,
    rowsNumber: 15,
});

async function onRequest(props) {
    const { page, rowsPerPage, sortBy, descending } = props.pagination;
    const filter = props.filter;
    loading.value = true;

    const fetchCount = rowsPerPage === 0 ? 0 : rowsPerPage;
    const order_by = descending ? "-" + sortBy : sortBy;
    const { data, total = 0 } = await PersonasService.getData({
        params: { rowsPerPage: fetchCount, page, search: filter, order_by },
    });
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
    personasformRef.value.loading = true;
    try {
        personasformRef.value.form.nombre_completo = personasformRef.value.form.nombres + ' ' + personasformRef.value.form.a_paterno + ' ' + personasformRef.value.form.a_materno;
        await PersonasService.save(personasformRef.value.form);
        personasformRef.value.loading = false;
        personasformRef.value.show = false;
        tableRef.value.requestServerInteraction();
        $q.notify({
            type: 'positive',
            message: 'Guardado con Exito.',
            position: 'top-right',
            progress: true,
            timeout: 1000,
        })
    } catch (e) {
        personasformRef.value.setErrors(e.response.data.errors);
        personasformRef.value.loading = false;
    }
}

async function editar(id) {
    personasformRef.value.show = true;
    const row = await PersonasService.get(id);
    personasformRef.value.setValue(row);
}

async function eliminar(id) {
    $q.dialog({
        title: "Eliminar",
        message:
            "¿Estas seguro de eliminar este registro? Este proceso es irreversible.",
        cancel: true,
        persistent: true,
    }).onOk(async () => {
        await PersonasService.delete(id);
        tableRef.value.requestServerInteraction();
        $q.notify({
            type: 'positive',
            message: 'Eliminado con Exito.',
            position: 'top-right',
            progress: true,
            timeout: 1000,
        })
    });
}
</script>
  
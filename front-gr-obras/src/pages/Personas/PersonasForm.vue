<template>
    <q-dialog v-model="show" @hide="reset()" persistent>
        <q-card style="width: 100%; max-width: 700px">
            <q-card-section>
                <div class="text-h6">Persona</div>
            </q-card-section>

            <q-separator />

            <q-card-section>
                <div class="row justify-between">
                    <div class="col-12 col-sm-6 q-px-xs">
                        <SelectTipoDoc v-model="form.tipo_doc" :error-message="errors.tipo_doc"
                            :error="errors.tipo_doc != null" />
                    </div>
                    <div class="col-12 col-sm-6 q-px-xs">
                        <q-input outlined borderless dense debounce="300" v-model="form.num_doc" label="Num. Doc."
                            :error-message="errors.num_doc" :error="errors.num_doc != null" />
                    </div>
                </div>
                <div class="row justify-between">
                    <div class="col-12 col-sm-4 q-px-xs">
                        <q-input outlined borderless dense debounce="300" v-model="form.nombres" label="Nombres"
                            :error-message="errors.nombres" :error="errors.nombres != null" />
                    </div>
                    <div class="col-12 col-sm-4 q-px-xs">
                        <q-input outlined borderless dense debounce="300" v-model="form.a_paterno" label="A. Paterno"
                            :error-message="errors.a_paterno" :error="errors.a_paterno != null" />
                    </div>
                    <div class="col-12 col-sm-4 q-px-xs">
                        <q-input outlined borderless dense debounce="300" v-model="form.a_materno" label="A. Materno"
                            :error-message="errors.a_materno" :error="errors.a_materno != null" />
                    </div>
                </div>
                <div class="row justify-between">
                    <div class="col-12 col-sm-4 q-px-xs">
                        <q-input type="email" outlined borderless dense debounce="300" v-model="form.email" label="Email"
                            :error-message="errors.email" :error="errors.email != null" />
                    </div>
                    <div class="col-12 col-sm-4 q-px-xs">
                        <q-input outlined borderless dense debounce="300" v-model="form.direccion" label="Dirección"
                            :error-message="errors.direccion" :error="errors.direccion != null" />
                    </div>
                    <div class="col-12 col-sm-4 q-px-xs">
                        <q-input outlined borderless dense debounce="300" v-model="form.celular" label="Celular"
                            :error-message="errors.celular" :error="errors.celular != null" />
                    </div>
                </div>
                <div class="row justify-between">
                    <SelectUbigeo ref="ubigeoSelectRef" :ubigeo_cod="form.ubigeo_cod" @selectedItem="updateUbigeo($event)">
                    </SelectUbigeo>
                </div>

                <div class="q-px-xs">
                    <q-separator class="q-my-md" />
                </div>

                <div class="row justify-between items-center q-mb-md">
                    <div class="col-8 col-sm-8 q-px-xs">
                        <SelectProfesion ref="profesionSelectRef" @selectedItem="updateProfesion($event)" />
                    </div>
                    <div class="col-4 col-sm-4 q-px-xs">
                        <q-btn color="primary" label="Agregar" :loading="btnLoadings[0]" @click="addProfesion()"
                            class="q-mr-xs" />
                        <q-btn :loading="btnLoadings[1]" label="Limpiar" @click="cleanProfesion()" />
                    </div>
                </div>

                <div class="q-px-xs">
                    <q-markup-table dense separator="cell" flat bordered>
                        <thead>
                            <tr>
                                <th class="text-center" colspan="3">Profesiones</th>
                            </tr>
                            <tr>
                                <th class="text-center">Id</th>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(p, i) in form.profesiones" :key="p">
                                <td>{{ p.id }}</td>
                                <td>{{ p.nombre }}</td>
                                <td class="text-center">
                                    <q-btn size="sm" outline color="red" round @click="removeProfesion(i)" icon="delete" />
                                </td>
                            </tr>
                        </tbody>
                    </q-markup-table>
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
import SelectTipoDoc from "src/components/SelectTipoDoc.vue";
import SelectUbigeo from "src/components/SelectUbigeo.vue";
import SelectProfesion from "src/components/SelectProfesion.vue";

const emits = defineEmits(["save"]);

//Estados reactivos
const form = ref({
    id: null,
    tipo_doc: null,
    num_doc: null,
    nombres: null,
    a_paterno: null,
    a_materno: null,
    nombre_completo: null,
    email: null,
    direccion: null,
    celular: null,
    administrativo_id: null,
    trabajador_id: null,
    ubigeo_cod: null,
    profesiones: []
});
const errors = ref({});
const show = ref(false);
const loading = ref(false);
const btnLoadings = ref([false, false]);
const ubigeoSelectRef = ref(null);
const profesionSelectRef = ref(null);
const profesion = ref({});

//onMounted
onMounted(() => {
    reset();
})

//Métodos
function setValue(values) {
    form.value = values;
    ubigeoSelectRef.value.getUbigeo(form.value.ubigeo_cod);
}

function save() {
    emits("save");
}

function addProfesion() {
    if (form.value.profesiones) {
        form.value.profesiones.push(profesion.value);
    } else {
        form.value.profesiones = [];
        form.value.profesiones.push(profesion.value);
    }
}

function removeProfesion(i) {
    if (form.value.profesiones.length != 0) {
        form.value.profesiones.splice(i, 1)
    }
}

function reset() {
    form.value = {}
    errors.value = {};
}

function setErrors(row) {
    errors.value.tipo_doc = row.tipo_doc ? row.tipo_doc[0] : null;
    errors.value.num_doc = row.num_doc ? row.num_doc[0] : null;
    errors.value.nombres = row.nombres ? row.nombres[0] : null;
    errors.value.a_paterno = row.a_paterno ? row.a_paterno[0] : null;
    errors.value.a_materno = row.a_materno ? row.a_materno[0] : null;
    errors.value.email = row.email ? row.email[0] : null;
    errors.value.direccion = row.direccion ? row.direccion[0] : null;
    errors.value.celular = row.celular ? row.celular[0] : null;
    errors.value.ubigeo_cod = row.ubigeo_cod ? row.ubigeo_cod[0] : null;
}

function updateUbigeo(event) {
    form.value.ubigeo_cod = event;
}

function updateProfesion(event) {
    profesion.value = event;
};

function cleanProfesion() {
    btnLoadings.value[1] = true;
    profesion.value = null;
    profesionSelectRef.value.reset();
    btnLoadings.value[1] = false;
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
  
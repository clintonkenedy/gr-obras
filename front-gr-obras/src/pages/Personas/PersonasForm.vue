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
                    <SelectUbigeo ref="ubigeoSelectRef" :ubigeo_cod="form.ubigeo_cod" @selectedItem="updateUbigeo($event)"></SelectUbigeo>
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
    ubigeo_cod: null
});
const errors = ref({});
const show = ref(false);
const loading = ref(false);
const ubigeoSelectRef = ref(null);

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
  
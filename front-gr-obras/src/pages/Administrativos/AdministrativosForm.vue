<template>
    <q-dialog v-model="show" @show="cargar()" @hide="reset()" persistent>
        <q-card style="width: 100%; max-width: 700px">
            <q-card-section>
                <div class="text-h6">Administrativo</div>
            </q-card-section>

            <q-separator />

            <q-card-section>
                <div class="row justify-between">
                    <div class="col-12 col-sm-6 q-px-xs">
                        <SelectTipoAdministrativo v-model="form.tipo"></SelectTipoAdministrativo>
                    </div>
                    <div class="col-12 col-sm-6 q-px-xs">
                        <q-input outlined borderless dense debounce="300" v-model="form.name" label="Nombre Usuario"
                            :error="errors.name != null">
                            <template v-slot:error>
                                <template v-for="(value, key) in errors.name" :key="key">
                                    *{{ value }}
                                </template>
                            </template>
                        </q-input>
                    </div>
                </div>
                <div class="row justify-between">
                    <div class="col-12 col-sm-6 q-px-xs">
                        <q-input type="email" outlined borderless dense debounce="300" v-model="form.email" label="Email"
                            :error="errors.email != null">
                            <template v-slot:error>
                                <template v-for="(value, key) in errors.email" :key="key">
                                    *{{ value }}
                                </template>
                            </template>
                        </q-input>
                    </div>
                    <div class="col-12 col-sm-6 q-px-xs">
                        <q-input :type="isPwd ? 'password' : 'text'" outlined borderless dense debounce="300"
                            v-model="form.password" label="Contraseña" :error="errors.password != null">
                            <template v-slot:append>
                                <q-icon :name="isPwd ? 'visibility_off' : 'visibility'" class="cursor-pointer"
                                    @click="isPwd = !isPwd" />
                            </template>
                            <template v-slot:error>
                                <template v-for="(value, key) in errors.password" :key="key">
                                    *{{ value }}
                                </template>
                            </template>
                        </q-input>
                    </div>
                </div>
                <div class="row justify-between">
                    <div class="col-12 col-sm-6 q-px-xs">
                        <SelectPersona ref="personaSelectRef" @selectedItem="updatePersona($event)"
                            :error-message="errors.persona_id" :error="errors.persona_id != null" />
                    </div>
                    <div class="col-12 col-sm-6 q-px-xs">
                        <SelectProfesion ref="profesionSelectRef" @selectedItem="updateProfesion($event)"
                            :error-message="errors.profesion" :error="errors.profesion != null" />
                    </div>
                </div>
                <div class="row justify-between">
                    <div class="col-12 col-sm-6 q-px-xs">
                        <q-input outlined borderless dense debounce="300" v-model="form.condicion" label="Condición"
                            :error-message="errors.condicion" :error="errors.condicion != null" />
                    </div>
                </div>
                <div class="q-gutter-y-sm column q-px-xs">
                    <q-list bordered separator>
                        <template v-for="(p, i) in roles" :key="i">
                            <q-item clickable v-ripple>
                                <q-item-section>
                                    <q-toggle keep-color v-model="form.rolesSelected" :label="`${p.name}`" color="primary"
                                        :val="p.id" hide-details>
                                    </q-toggle></q-item-section>
                            </q-item>
                        </template>
                    </q-list>
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
import RoleService from "src/services/RoleService";
import SelectPersona from "src/components/SelectPersona.vue";
import SelectProfesion from "src/components/SelectProfesion.vue";
import SelectTipoAdministrativo from "src/components/SelectTipoAdministrativo.vue";

const emits = defineEmits(["save"]);

const isPwd = ref(true);
const show = ref(false);
const loading = ref(false);
const roles = ref(false);

//Estados reactivos
const form = ref({
    id: null,
    name: null,
    email: null,
    password: null,
    tipo: null,
    persona_id: null,
    profesion: null,
    profesion_id: null,
    condicion: null,
    rolesSelected: [],
});

const errors = ref();
const personaSelectRef = ref(null);
const profesionSelectRef = ref(null);

//onMounted
onMounted(async () => {
    reset();
});

function setValue(values) {
    form.value.id = values.user.id;
    form.value.name = values.user.name;
    form.value.email = values.user.email;
    form.value.tipo = values.user.tipo;
    form.value.persona_id = values.user.persona_id;
    form.value.profesion = values.user.profesion;
    form.value.profesion_id = values.user.profesion_id;
    form.value.condicion = values.user.condicion;
    form.value.rolesSelected = values.rolesSelected;
    personaSelectRef.value.getItem(values.user.persona_id);
    profesionSelectRef.value.getItem(values.user.profesion_id);
}
function save() {
    emits("save");
}

function reset() {
    form.value = {};
    form.value.rolesSelected = [];
    errors.value = {};
}

async function cargar() {
    const { data } = await RoleService.getData({
        params: { rowsPerPage: 0, order_by: "id" },
    });
    roles.value = data;
}

function updatePersona(event) {
    form.value.persona_id = event.id;
};

function updateProfesion(event) {
    form.value.profesion = event.nombre;
};

defineExpose({
    show,
    save,
    loading,
    form,
    reset,
    setValue,
    errors,
});
</script>
<template>
  <q-dialog v-model="show" @show="cargar()" @hide="reset()" persistent>
    <q-card class="my-card">
      <q-card-section>
        <div class="text-h6">Cargo</div>
      </q-card-section>

      <q-separator />

      <q-card-section>
        <q-input
          outlined
          borderless
          dense
          debounce="300"
          v-model="form.name"
          label="Nombre"
          :error="errors.name != null"
        >
          <template v-slot:error>
            <template v-for="(value, key) in errors.name" :key="key">
              *{{ value }}
            </template>
          </template>
        </q-input>
        <q-input
          type="email"
          outlined
          borderless
          dense
          debounce="300"
          v-model="form.email"
          label="Email"
          :error="errors.email != null"
        >
          <template v-slot:error>
            <template v-for="(value, key) in errors.email" :key="key">
              *{{ value }}
            </template>
          </template>
        </q-input>
        <q-input
          :type="isPwd ? 'password' : 'text'"
          outlined
          borderless
          dense
          debounce="300"
          v-model="form.password"
          label="Contraseña"
          :error="errors.password != null"
        >
          <template v-slot:append>
            <q-icon
              :name="isPwd ? 'visibility_off' : 'visibility'"
              class="cursor-pointer"
              @click="isPwd = !isPwd"
            />
          </template>
          <template v-slot:error>
            <template v-for="(value, key) in errors.password" :key="key">
              *{{ value }}
            </template>
          </template>
        </q-input>
        <div class="q-gutter-y-sm column">
          <q-list bordered separator>
            <template v-for="(p, i) in roles" :key="i">
              <q-item clickable v-ripple>
                <q-item-section>
                  <q-toggle
                    keep-color
                    v-model="form.rolesSelected"
                    :label="`${p.name}`"
                    color="secondary"
                    :val="p.id"
                    hide-details
                  >
                  </q-toggle
                ></q-item-section>
              </q-item>
            </template>
          </q-list>
        </div>

        <p>{{ form }}</p>
      </q-card-section>
      <q-separator />

      <q-card-actions align="right">
        <q-btn flat label="Cancelar" color="gray" v-close-popup />
        <q-btn
          flat
          label="Guardar"
          color="primary"
          @click="save"
          :loading="loading"
        />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>
<script setup>
import { ref, onMounted } from "vue";
import RoleService from "src/services/RoleService";

const emits = defineEmits(["save"]);
// const rolesSelected = ref([]);
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
  rolesSelected: [],
});

const errors = ref();

//onMounted
onMounted(async () => {
  reset();
});

function setValue(values) {
  form.value.id = values.user.id;
  form.value.name = values.user.name;
  form.value.email = values.user.email;
  form.value.rolesSelected = values.rolesSelected;
}
function save() {
  emits("save");
}
function reset() {
  // form.value.id= null
  // form.value.name=null
  // form.value.description=null
  form.value = {};
  form.value.rolesSelected = [];
  errors.value = {};
  // errors.value.name = null ;
  // errors.value.description = null ;
}
async function cargar() {
  const { data } = await RoleService.getData({
    params: { rowsPerPage: 0, order_by: "id" },
  });
  roles.value = data;
  console.log(roles.value);
}

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
<style lang="sass" scoped>
.my-card
  width: 100%
  max-width: 80vw
</style>

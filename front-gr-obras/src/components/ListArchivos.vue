<template>
  <q-list bordered class="rounded-borders q-mx-sm">
    <q-item-label header>Archivos cargados</q-item-label>

    <q-scroll-area style="height: 120px;">
      <q-item v-for="(file, i) in files" :key="i">
        <q-item-section avatar top>
          <q-icon name="attach_file" color="black" size="34px" />
        </q-item-section>

        <q-item-section top>
          <q-item-label lines="1">
            {{ file.nombre }} - {{ file.size }}
            <span class="text-grey-8"><q-icon name="picture_as_pdf" /></span>
          </q-item-label>
          <q-item-label caption lines="1">
            <span class="text-weight-medium">{{ file.desc }}</span>
          </q-item-label>
          <!-- <q-item-label lines="1" class="q-mt-xs text-body2 text-weight-bold text-primary text-uppercase">
                      <span class="cursor-pointer">Cesar in GitHub </span>
                    </q-item-label> -->
        </q-item-section>

        <q-item-section top side>
          <div class="text-grey-8 q-gutter-sm">
            <q-btn @click="descargar(file)" size="11px" dense round icon="download" color="green" outline />
            <q-btn @click="eliminar(file.id)" size="11px" dense round icon="delete" color="red" outline />
          </div>
        </q-item-section>
      </q-item>
    </q-scroll-area>

  </q-list>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import ArchivosService from "src/services/ArchivosService";
import { useQuasar } from "quasar";
const $q = useQuasar();
//Emits
const emits = defineEmits(["deleteFile"]);

//Props
const props = defineProps({
  files: { default: null },
});

//Estados reactivos
// const stringOptions = ref([]);

//OnMounted
// onMounted(async () => {

// })

//Métodos
const descargar = (archivo) => {
  if (['jpg', 'jpeg', 'png', 'gif', 'bmp', 'pdf'].includes(archivo.extension)) {
    window.open(archivo.url, '_blank')
  } else {
    window.location.href = archivo.url;
  }
};
async function eliminar(id) {
  $q.dialog({
    title: "Confirm",
    message:
      "¿Estas seguro de eliminar este registro? Este proceso es irreversible.",
    cancel: true,
    persistent: true,
  }).onOk(async () => {
    await ArchivosService.delete(id);
    $q.notify({
      type: 'positive',
      message: 'Eliminado con Exito.',
      position: 'top-right',
      progress: true,
      timeout: 1000,
    })
    emits("deleteFile");
  });
}

//Expose
defineExpose({

});
</script>
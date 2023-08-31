<template>
    <q-btn @click="descargar()" class="q-mx-sm" outline color="primary"
        icon="file_download" :label="label" />
</template>

<script setup>
import { ref, onMounted } from 'vue';

//Emits


//Props
const props = defineProps({
    form: { default: null },
    label: { default: null }
});

//Estados reactivos
const stringOptions = ref([]);

//OnMounted
onMounted(async () => {

})

//Métodos
const descargar = () => {
  if (['jpg', 'jpeg', 'png', 'gif', 'bmp', 'pdf'].includes(props.form.extension)) {
    window.open(props.form.url, '_blank')
  } else {
    window.location.href = props.form.url;
  }
};

//Expose
defineExpose({

});
</script>
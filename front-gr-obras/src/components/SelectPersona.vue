<template>
    <q-select @update:model-value="update($event)" v-model="model" borderless dense debounce="300" outlined use-input
        hide-selected fill-input input-debounce="0" label="Persona" :options="options" option-label="nombre_completo"
        option-value="id" @filter="filter">
        <template v-slot:no-option>
            <q-item>
                <q-item-section class="text-grey">
                    No se han encontrado resultados
                </q-item-section>
            </q-item>
        </template>
    </q-select>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import PersonasService from 'src/services/PersonasService';

//Emits
const emits = defineEmits(["selectedItem"]);

//Props
const props = defineProps({
    id: { type: Number, default: null },
});

//Estados reactivos
const stringOptions = ref([]);
const options = ref([]);
const model = ref(null);

//OnMounted
onMounted(async () => {
    stringOptions.value = (await PersonasService.getData({ params: { sort_by: 'id', direction: 'desc' } })).data;
    if (props.id) {
        model.value = (await PersonasService.get(props.id));
    }
})

//Métodos
async function getItem(id) {
    model.value = (await PersonasService.get(id));
};

async function filter(val, update) {
    setTimeout(() => {
        update(async () => {
            if (val === '') {
                options.value = stringOptions.value
            }
            else {
                const needle = val.toLowerCase()
                options.value = (await PersonasService.getData({ params: { sort_by: 'id', direction: 'desc', search: needle } })).data;
            }
        })
    }, 500)
};

function update(event) {
    emits("selectedItem", event)
}

function reset() {
    model.value = null;
}

//Expose
defineExpose({
    getItem,
    reset
});
</script>
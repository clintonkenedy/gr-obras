<template>
    <q-select borderless dense debounce="300" outlined :options="options" label="Meses" />
</template>

<script setup>
const options = [
    'Enero',
    'Febrero',
    'Marzo',
    'Abril',
    'Mayo',
    'Junio',
    'Julio',
    'Agosto',
    'Septiembre',
    'Octubre',
    'Noviembre',
    'Diciembre'
]
</script>
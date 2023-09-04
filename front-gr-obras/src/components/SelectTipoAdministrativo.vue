<template>
    <q-select borderless dense debounce="300" outlined :options="options" label="Tipo A." />
</template>

<script setup>
const options = [
    'COORDINADOR',
    'SUPERVISOR',
    'RESIDENTE',
    'ECONOMISTA'
]
</script>
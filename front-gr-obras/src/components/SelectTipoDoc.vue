<template>
    <q-select borderless dense debounce="300" outlined :options="options" label="Tipo Doc." />
</template>

<script setup>
const options = [
    'DNI',
    'RUC'
]
</script>
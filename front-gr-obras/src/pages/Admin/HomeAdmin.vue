<template>
  <div class="my-card q-ma-md">
    <q-card class="my-card" flat bordered>
      <q-card-section>
        <q-select v-model="obra"
          :options="['2250752: MEJORAMIENTO DE LOS SERVICIOS EDUCATIVOS EN E.B.R ORIENTADO A LA ECOEFICIENCIA EN LA II.EE. INDEPENDENCIA NACIONAL DE LA CIUDAD DE PUNO']"
          label="Standard" />
      </q-card-section>
    </q-card>

    <div class="row q-mt-lg">
      <div class="col">
        <q-img src="https://cdn.quasar.dev/img/parallax2.jpg">
          <div class="absolute-bottom text-subtitle1 text-center">
            Foto
          </div>
        </q-img>
      </div>
      <div class="col q-ma-md">
        <div class="row">
          <div class="col q-ma-md">
            <q-list dense bordered padding class="rounded-borders">
              <q-item clickable v-ripple>
                <q-item-section>
                  <b>Meta:</b>
                </q-item-section>
              </q-item>

              <q-item clickable v-ripple>
                <q-item-section>
                  32 AULAS PEDAGÓGICAS CON EQUIPAMIENTO Y MOBILIARIO
                </q-item-section>
              </q-item>

              <q-item clickable v-ripple>
                <q-item-section>
                  5 LABORATORIOS Y AMBIENTES COMPONENTES
                </q-item-section>
              </q-item>
            </q-list>
          </div>
          <div class="col q-ma-md">
            <q-list dense bordered padding class="rounded-borders">
              <q-item clickable v-ripple>
                <q-item-section>

                </q-item-section>
              </q-item>

              <q-item clickable v-ripple>
                <q-item-section>
                  <b>EXPEDIENTE INICIAL:</b> $/. 113,047,218
                </q-item-section>
              </q-item>

              <q-item clickable v-ripple>
                <q-item-section>
                  <b>EXPEDIENTE MODIFICADO:</b> $/. 136,281,040
                </q-item-section>
              </q-item>
            </q-list>
          </div>
        </div>
        <div class="row">
          <div class="col q-ma-md">
            <q-list dense bordered padding class="rounded-borders">
              <q-item clickable v-ripple>
                <q-item-section>
                  <b>BENEFICIARIOS:</b>
                </q-item-section>
              </q-item>

              <q-item clickable v-ripple>
                <q-item-section>
                  20,966 ESTUDIANTES
                </q-item-section>
              </q-item>
            </q-list>
          </div>
          <div class="col q-ma-md">
            <Bar :data="data" :options="options" />
          </div>
        </div>
        <div class="row">
          <div class="col q-ma-md">
            <q-list dense bordered padding class="rounded-borders">

              <q-item clickable v-ripple>
                <q-item-section>
                  <b>PLAZO DE EJECUCIÓN INICIAL:</b> 465 Días Calendario
                </q-item-section>
              </q-item>

              <q-item clickable v-ripple>
                <q-item-section>
                  <b>PLAZO DE EJECUCIÓN MODIFICADO:</b> 1826 Días Calendario
                </q-item-section>
              </q-item>
            </q-list>
          </div>
          <div class="col q-ma-md">
            <q-list dense bordered padding class="rounded-borders" >
              <q-item clickable v-ripple>
                <q-item-section>
                  <b>PIM:</b> 4,245,915
                </q-item-section>
              </q-item>
            </q-list>
          </div>
        </div>
        <div class="row">
          <div class="col q-ma-md">
            <q-list dense bordered padding class="rounded-borders">
              <q-item clickable v-ripple>
                <q-item-section>
                  <b>MODALIDAD DE EJECUCIÓN:</b> POR CONTRATA
                </q-item-section>
              </q-item>
            </q-list>
          </div>
          <div class="col q-ma-md">
            <q-list dense bordered padding class="rounded-borders">
              <q-item clickable v-ripple>
                <q-item-section>
                  <b>MONTO DE INVERSIÓN:</b> S/. 30,955,119
                </q-item-section>
              </q-item>
            </q-list>
          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<script setup>
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale
} from 'chart.js'
import { Bar } from 'vue-chartjs';
import { ref } from "vue";
ChartJS.register(CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend)

const obra = ref(null);
const options = {
  responsive: true,
  maintainAspectRatio: false
}

const data = {
  labels: [
    'Físico',
    'Financiero',
  ],
  datasets: [
    {
      label: '(%)',
      backgroundColor: ['#f87979', '#000'],
      data: [56.5, 28.9]
    },
  ]
}
</script>

<style></style>

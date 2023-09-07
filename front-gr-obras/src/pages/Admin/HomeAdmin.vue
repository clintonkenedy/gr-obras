<template>
  <div class="q-px-md q-pt-md q-pb-sm">
    <q-card flat bordered>
      <q-card-section class="text-center row items-center justify-center q-pa-sm">
        <span class="text-weight-medium text-subtitle1">20406325815 - GOBIERNO REGIONAL PUNO</span>
      </q-card-section>
    </q-card>
  </div>

  <div class="q-px-sm row justify-between">
    <div class="q-pa-sm col-12 col-sm-6 col-md-6">
      <q-card flat bordered style="height: 100%;">
        <q-card-section class="q-pt-sm">
          <div class="text-subtitle2">1.- Datos Generales:</div>
          <div class="text-h5 q-mt-sm q-mb-md">
            <SelectObra ref="obraRef" @selectedItem="e => obtenerDatos(e)"></SelectObra>
          </div>
          <q-markup-table separator="cell" flat bordered>
            <thead>
              <tr>
                <th colspan="4">
                  <div class="row justify-between items-center">
                    <div>
                      <q-icon name="las la-calendar" size="sm" class="q-mr-xs" />
                      <strong>{{ obra.cui }} - {{ obra.nombre_proyecto }}</strong> |
                      Meta: {{ obra.meta }}
                    </div>
                    <div>
                      <div class="text-weight-bold q-pa-xs rounded-borders"
                        :class="{ 'bg-green-2 text-green-10': obra.estado == 'pendiente' }">
                        {{ obra.estado }}
                      </div>
                    </div>
                  </div>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="width:25%;">
                  <div class="row q-pr-md">
                    <q-icon name="las la-calendar-check" size="xs" class="q-mr-xs" />
                    <span>Sector: <br> <span class="text-blue-grey-6">{{ obra.sector }}</span></span>
                  </div>
                </td>
                <td style="width:25%;">
                  <div class="row q-pr-md">
                    <q-icon name="las la-calendar-check" size="xs" class="q-mr-xs" />
                    <span>Duración: <br> <span class="text-blue-grey-6">{{ obra.dura_dias }}</span></span>
                  </div>
                </td>
                <td style="width:25%;">
                  <div class="row q-pr-md">
                    <q-icon name="las la-clock" size="xs" class="q-mr-xs" />
                    <span>Inicio: <br> <span class="text-blue-grey-6">{{ obra.fec_ini }}</span></span>
                  </div>
                </td>
                <td style="width:25%;">
                  <div class="row q-pr-md">
                    <q-icon name="las la-clock" size="xs" class="q-mr-xs" />
                    <span>Fin: <br> <span class="text-blue-grey-6">{{ obra.fec_fin }}</span></span>
                  </div>
                </td>
              </tr>
            </tbody>
          </q-markup-table>

          <div class="row justify-between text-h5 q-mt-md">
            <SelectUbigeo ref="ubigeoSelectRef" :ubigeo_cod="obra.ubigeo_cod" :disabled="true"></SelectUbigeo>
          </div>
        </q-card-section>
        <q-separator />
        <q-card-actions>
          <q-btn flat color="primary" to="/obras">
            Acceder
          </q-btn>
        </q-card-actions>
      </q-card>
    </div>

    <div class="q-pa-sm col-12 col-sm-6 col-md-6">
      <q-card flat bordered style="height: 100%;">
        <q-card-section class="q-pt-sm">
          <div class="text-center text-subtitle2 q-pt-sm q-mb-md">
            {{ obra.codigo }} - {{ obra.nombre_proyecto }}
            Meta: {{ obra.meta }}
          </div>
          <div>
            <q-img class="rounded-borders" style="min-width: 100%; height: 220px;"
              src="https://cdn.quasar.dev/img/parallax2.jpg">
              <div class="absolute-bottom text-subtitle1 text-center">
                Imagen de la Obra
              </div>
            </q-img>
          </div>
        </q-card-section>
      </q-card>
    </div>
  </div>

  <div class="q-px-sm row justify-between">
    <div class="q-pa-sm col-12 col-sm-6 col-md-6">
      <q-card flat bordered style="height: 100%;">
        <q-card-section class="q-pt-sm">
          <div class="text-subtitle2">2.- Datos Personales de los Responsables de la Obra</div>
        </q-card-section>
        <q-separator />
        <q-card-actions>

        </q-card-actions>
      </q-card>
    </div>

    <div class="q-pa-sm col-12 col-sm-6 col-md-6">
      <q-card flat bordered style="height: 100%;">
        <q-card-section class="q-pt-sm">
          <div class="text-subtitle2">3.- Periodo de Ejecución</div>
        </q-card-section>
        <q-separator />
        <q-card-actions>

        </q-card-actions>
      </q-card>
    </div>
  </div>

  <div class="q-px-sm row justify-between">
    <div class="q-pa-sm col-12 col-sm-6 col-md-6">
      <q-card flat bordered style="height: 100%;">
        <q-card-section class="q-pt-sm">
          <div class="text-subtitle2">4.- Presupuesto de la Obra</div>
        </q-card-section>
      </q-card>
    </div>

    <div class="q-pa-sm col-12 col-sm-6 col-md-6">
      <q-card flat bordered style="height: 100%;">
        <q-card-section class="q-pt-sm">
          <div class="text-subtitle2">5.- Avance Valorizado del Proyecto</div>
        </q-card-section>
      </q-card>
    </div>
  </div>

  <div class="q-px-md q-pt-sm q-pb-sm">
    <q-card flat bordered>
      <div class="text-center text-subtitle2 q-pt-sm">
        Control de Curva "S" (Curva "S")
      </div>
      <q-card-section class="text-center row items-center justify-center q-pa-sm">
        <div style="width: 100%; height: 500px;">
          <Line id="my-chart-id" :options="chartOptions" :data="lineChartData" :style="myStyles" />
        </div>
      </q-card-section>
    </q-card>
  </div>

  <div class="q-px-sm row justify-between q-pb-sm">
    <div class="q-pa-sm col-12 col-sm-6 col-md-6">
      <q-card flat bordered style="height: 100%;">
        <q-card-section class="q-pt-sm">
          <div class="text-subtitle2">6.- Control de Avance del Proyecto</div>
        </q-card-section>
      </q-card>
    </div>

    <div class="q-pa-sm col-12 col-sm-6 col-md-6">
      <q-card flat bordered style="height: 100%;">
        <q-card-section class="q-pt-sm">
          <div class="text-subtitle2">Metas del Proyecto</div>
        </q-card-section>
      </q-card>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import SelectObra from 'src/components/SelectObra.vue';
import SelectUbigeo from 'src/components/SelectUbigeo.vue';
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement
} from 'chart.js'
import { Bar, Line } from 'vue-chartjs';
import AvancesMesService from 'src/services/AvancesMesService';

//Estados reactivos
const obra = ref({});
const obraRef = ref(null);
const ubigeoSelectRef = ref(null);

//Gráfico
ChartJS.register(CategoryScale, PointElement, LineElement, LinearScale, BarElement, Title, Tooltip, Legend);

// const options = {
//   responsive: true,
//   maintainAspectRatio: false
// }

const myStyles = {
  height: `500px`,
  width: '100%',
  position: 'relative'
}

// const data = {
//   labels: [
//     'Físico',
//     'Financiero',
//   ],
//   datasets: [
//     {
//       label: '(%)',
//       backgroundColor: ['#f87979', '#000'],
//       data: [56.5, 28.9]
//     },
//   ]
// }

const lineChartData = ref({
  labels: ['Inicio', 'jun-23', 'jun-23', 'jun-23', 'jun-23', 'jul-23', 'jul-23', 'jul-23', 'jul-23', 'ago-23', 'ago-23', 'ago-23', 'ago-23'],
  datasets: [
    {
      label: 'Programado',
      backgroundColor: '#ef4444',
      borderColor: '#ef4444',
      borderWidth: 1,
      pointBorderColor: '#ef4444',
      data: [0, 5, 10, 15, 20, 25, 35, 45, 55, 65, 75, 85, 100]
    },
    {
      label: 'Ejecutado',
      backgroundColor: '#3b82f6',
      borderColor: '#3b82f6',
      borderWidth: 1,
      pointBorderColor: '#3b82f6',
      data: [0, 2, 5, 7, 8, 10]
    },
    {
      label: 'Financiero',
      backgroundColor: '#22c55e',
      borderColor: '#22c55e',
      borderWidth: 1,
      pointBorderColor: '#22c55e',
      data: [0, 3, 7, 12, 17, 22]
    }
  ]
});

onMounted(() => {
  // obtenerDatos();
})

async function obtenerDatos(e) {
  try {
    obra.value = e;
    const res = await AvancesMesService.get(obra.value.id);
    ubigeoSelectRef.value.getUbigeo(obra.value.ubigeo_cod);
    lineChartData.value =
    {
      labels: res.avances.map(e => e.codigo),
      datasets: [
        {
          label: 'Programado',
          backgroundColor: '#ef4444',
          borderColor: '#ef4444',
          borderWidth: 1,
          pointBorderColor: '#ef4444',
          data: res.avances.map(e => e.acum_prog)
        },
        {
          label: 'Ejecutado',
          backgroundColor: '#3b82f6',
          borderColor: '#3b82f6',
          borderWidth: 1,
          pointBorderColor: '#3b82f6',
          data: res.avances.map(e => e.acum_fisc)
        },
        {
          label: 'Financiero',
          backgroundColor: '#22c55e',
          borderColor: '#22c55e',
          borderWidth: 1,
          pointBorderColor: '#22c55e',
          data: res.avances.map(e => e.acum_finan)
        }
      ]
    };
  } catch (e) {
    console.log(e);
  }
}

</script>
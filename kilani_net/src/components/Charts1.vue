<template>
    <canvas id="chart"></canvas>
</template>


<script setup>
import Chart from 'chart.js/auto';
import { onMounted } from 'vue';
const labels = ['1Mb','2Mb','3MB', '4Mb', '5Mb'];
const data = {
  labels: labels,
  datasets: [{
    label: 'test',
    data: [250,100,150,10,5],// 500
  }]
};
const config = {
  type: 'bar',
  data: data,
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  },
};
onMounted(()=>{
    const chart = new Chart(
        document.getElementById('chart'),
        config
    )
})
</script>
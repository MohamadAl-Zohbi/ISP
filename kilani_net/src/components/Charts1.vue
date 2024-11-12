<template>
    <canvas id="chart"></canvas>
</template>


<script setup>
import Chart from 'chart.js/auto';
import { onMounted } from 'vue';
const props = defineProps({
  items: {
    type: Array,
    required: true,
  },
});
const labels = props.items[0];
const data = {
  labels: labels,
  datasets: [{
    label: 'test',
    data: props.items[1],// 500
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
    console.log(props.items)
})
</script>
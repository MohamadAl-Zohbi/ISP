<template>
    <canvas id="myChart"></canvas>
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
const labels = [];
const data_labels = [];
const data = {
  labels: labels,
  datasets: [{
    data:data_labels,
    backgroundColor: [
      'green',
      'red',
      'yellow',
      'aqua'
    ],
    hoverOffset: 4
  }]
};
const config = {
  type: 'pie',
  data: data,
};
onMounted(()=>{
    let items = props.items;
for (let index = 0; index < items.length; index++) {
    if (items[index].data == '0') {
        items[index].data = 'expired' 
    }else if(items[index].data == '1'){
        items[index].data = 'frozen' 

    }
   labels.push(items[index].data)
   data_labels.push(items[index].count)
}
console.log(labels)
    
    const myChart = new Chart(
        document.getElementById('myChart'),
        config
    )
})
</script>
<template>
  <div style="width: 40%;height: 500px; display:inline-block;align-items: center; float: left;padding:20px;">
    <Charts2 v-if="is_loaded" :items="diagramme" />
    <div v-if="!is_loaded" style="width: 500px; height: 500px;border-radius:50%;"
      class='animate-spin rounded-full h-16 w-16 border-t-4 border-blue-500 border-solid'>

    </div>
  </div>

  <div
    style="width: 40%;height: 500px;display:inline-block; float: right;align-items: center;display:flex;padding: 20px;">
    <Charts1 v-if="is_loaded" :items="courbe" />
  </div>
</template>

<script>
import Charts1 from '@/components/Charts1.vue';
import Charts2 from '@/components/Charts2.vue';
import { host } from '@/host';
import axios from 'axios';
export default {
  data() {
    return {
      diagramme: [],
      courbe: [[],[]],
      is_loaded: false

    }
  },
  mounted() {
    this.getDataFroDiagramme();
    this.getDataForCourbe();
  },
  methods: {
    async getDataFroDiagramme() {
      this.is_loading = true;
      let token = localStorage.getItem('token')
      try {
        const response = await axios.get(`http://${host}:8000/api/get_renews_waiting_checked_from_to`, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
          params: {
            from: this.date1(),
            to: this.date2(),
          },
        });


        console.log(response.data);
        if (response.data.status) {
          let results = response.data.details;
          this.is_loading = false
          for (let index = 0; index < results.length; index++) {
            this.diagramme.push(results[index])
          }
          // if (this.results == 'no result') {
          //     this.results = []
          // }
          if (response.data.details == 'no permission') {
            location.replace('/super/no-permission')

          }
        }



      } catch (error) {

        console.log(error)
      }

      try {
        const response = await axios.get(`http://${host}:8000/api/get_expired_frozen_customers`, {
          headers: {
            Authorization: `Bearer ${token}`,
          },

        });
        console.log(response.data)
        if (response.data.status) {
          let results = response.data.details;
          this.is_loading = false
          for (let index = 0; index < results.length; index++) {
            this.diagramme.push(results[index])
          }
          if (response.data.details == 'no permission') {
            location.replace('/super/no-permission')

          }
        }
      } catch (error) {
        console.log(error)
      }
      // console.log(this.data, "ss")
      let total_customers = 0;
      for (let index = 0; index < this.diagramme.length; index++) {
        total_customers += this.diagramme[index].count;

      }
      // console.log(total_customers)
      // waiting // checked // expired // frozen (*)

      // this.is_loaded = true
    },
    async getDataForCourbe() {
      try {
        const response = await axios.get(`http://${host}:8000/api/get_renews_from_to`, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`,
          },
          params: {
            from: this.date1(),
            to: this.date2(),
          },
        });
        console.log(response.data)
        /* to be added later on ..!!!! */
        // if (!response.data.status) {
        //   alert('courbe Alert!! no renews yet ..!');
        //   return false;
        // }
        for (let index = 0; index < response.data.details.length; index++) {
          this.courbe[0].push(response.data.details[index].service)
          this.courbe[1].push(response.data.details[index].count)
          // this.courbe.count.push(response.data.count)
        }
        // console.log(this.courbe)
        this.is_loaded = true

      } catch (error) {

        console.log(error)
      }
    },
    date1() {
      let date1 = new Date();
      date1.setDate(5);
      date1.setMonth(date1.getMonth());
      date1 = date1.toISOString().split('T')[0];
      console.log(date1)
      return date1
    },
    date2() {
      let date2 = new Date();
      date2.setDate(6); // 6 the 6 day will not be because the interval between [5:6[
      date2.setMonth(date2.getMonth() + 1);
      date2 = date2.toISOString().split('T')[0];
      console.log(date2)
      return date2
    }




  },
  components: {
    Charts1,
    Charts2,
  },
};
</script>

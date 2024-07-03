<template>
  <div class="row">
    <div clas="items">
      <div>

      </div>
    </div>
  </div>
</template>


<script setup>

import {onMounted} from "vue";
import axios from "axios";
import {useRoute} from 'vue-router'

const route = useRoute()
console.log(route.query)

onMounted(() => {
  axios.get(`v2/search-result?start_date=${route.query.startDate}&end_date=${route.query.endDate}&location=${route.query.location}`).then((res) => {
    console.log(res)
  })
})

</script>
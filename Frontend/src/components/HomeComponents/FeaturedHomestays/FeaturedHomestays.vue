<template>
   <div id="featured-cars-section" class="hidden">
      <div class="section-container">
         <p class="section-title">Homestay dành cho bạn</p>
         <div class="car-list" v-if="randomCars.length > 0">
            <ItemCard
               v-for="carItem in randomCars"
               :key="carItem.carId"
               :carItemProps="carItem"
               :imagePath="getImagePath(carItem.carImages)"
            />
         </div>
         <div v-else-if="errorMessage">{{ errorMessage }}</div>
         <div v-else>
            <stateLoading />
         </div>
      </div>
   </div>
</template>

<script setup>
import axios from "axios";
import { ref } from "vue";
import ItemCard from "@/components/HomeComponents/ItemCard/ItemCard.vue";
import stateLoading from "@/components/Loading/Loading.vue";
const randomCars = ref([]);
const errorMessage = ref(null);

const getRandomCars = async () => {
   try {
      const response = await axios.get("v2/cars/randomCars");
      if (response.status === 200) {
         randomCars.value = response.data.data.cars;
      }
   } catch (error) {
      errorMessage.value = error;
   }
};
getRandomCars();

const getImagePath = (carImages) => {
   if (carImages.length > 0) {
      return carImages[0].imagePath;
   }
   return null;
};
</script>

<style lang="scss" scoped>
@import "../../../assets/styles/MainStyles/HomeStyles.scss";
@import "./FeaturedHomestays.scss";
</style>

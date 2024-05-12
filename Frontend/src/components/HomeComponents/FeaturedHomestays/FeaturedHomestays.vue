<template>
   <div id="featured-homestays-section" class="hidden">
      <div class="section-container">
         <p class="section-title">Homestays dành cho bạn</p>
         <div class="homestay-list" v-if="homestays.length > 0">
            <ItemCard
               v-for="homestay in homestays"
               :key="homestays.homestayId"
               :itemProps="homestay"
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
const homestays = ref([]);
const errorMessage = ref(null);

const getHomestayList = async () => {
   try {
      const response = await axios.get("v2/homestays");
      if (response.status === 200) {
        homestays.value = response.data.data.homestays;
      }
   } catch (error) {
      errorMessage.value = error;
   }
};
getHomestayList();

// const getImagePath = (carImages) => {
//    if (carImages.length > 0) {
//       return carImages[0].imagePath;
//    }
//    return null;
// };
</script>

<style lang="scss" scoped>
@import "../../../assets/styles/MainStyles/HomeStyles.scss";
@import "./FeaturedHomestays.scss";
</style>

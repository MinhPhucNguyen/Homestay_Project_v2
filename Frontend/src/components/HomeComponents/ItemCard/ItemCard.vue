<template>
   <router-link
      :to="`/homestay/${(
         props.itemProps.slug
      )}`"
      class="homestay-item"
   >
      <div class="card">
         <div
            class="mini-fav-btn"
            :id="props.itemProps.homestayId"
         >
            <i class="fa-regular fa-heart"></i>
         </div>
         <img :src="imagePath" class="card-img-top" alt="homestay_image" />
         <div class="card-body">
            <h5 class="card-title text-uppercase">
               <span>
                  {{ props.itemProps.homestayName }}
               </span>
            </h5>
            <div class="info">
               <div class="desc-address d-flex">
                  <div class="d-flex align-items-center justify-content-center">
                     <font-awesome-icon icon="fa-solid fa-location-dot" />
                  </div>
                  <span>{{ props.itemProps.address }}</span>
               </div>
            </div>
            <div class="car-item-divider"></div>
            <div class="trip-price d-flex justify-content-between align-items-center mt-3">
<!--               <div class="desc-price">-->
<!--                  {{ formatCurrency(props.itemProps[0].pricePerNight) }}-->
<!--               </div>-->
            </div>
         </div>
      </div>
   </router-link>
</template>

<script setup>
import { formatCurrency } from "@/utils/formatCurrency.js";
import { useStore } from "vuex";
import { ref } from "vue";

const props = defineProps({
   itemProps: {
      type: Object,
      required: true,
   },
   imagePath: {
      type: String,
      required: false,
   },
});

const isFavorite = ref(false);
const store = useStore();
/**
 * TODO: Add car to favorite
 */
const addCarToFavorite = (event) => {
   const target = event.currentTarget;
   const homestayId = target.getAttribute("id");

   // if (carId != props.itemProps.homestayId) return;

   // isFavorite.value = !isFavorite.value;
   // target.classList.toggle("active");
   // if (target.classList.contains("active")) {
   //    store
   //       .dispatch("favorite/addCar", { id: props.itemProps.homestayId })
   //       .then((response) => {
   //          console.log(response);
   //       })
   //       .catch((error) => {
   //          console.log(error);
   //       });
   // } else {
   //    store
   //       .dispatch("favorite/removeCar", { id: props.carItemProps.carId })
   //       .then((response) => {
   //          console.log(response);
   //       })
   //       .catch((error) => {
   //          console.log(error);
   //       });
   // }
};

store.getters["favorite/getFavoriteCars"].some((car) => {
   if (car.carId === props.carItemProps.carId) {
      isFavorite.value = true;
      return true;
   } else {
      isFavorite.value = false;
      return false;
   }
});
</script>

<style scoped>
@import "./ItemCard.scss";
</style>

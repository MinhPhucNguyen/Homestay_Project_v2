<template>
   <router-link
      :to="`/car/${(
         props.carItemProps.brand +
         ' ' +
         props.carItemProps.carName +
         props.carItemProps.yearOfCar
      )
         .toLowerCase()
         .replace(/\s+/g, '-')}/${props.carItemProps.carId}`"
      class="car-item"
      v-if="props.carItemProps.status === 1"
   >
      <div class="card">
         <div
            class="mini-fav-btn"
            :class="{ active: isFavorite }"
            :id="props.carItemProps.carId"
            @click.prevent="addCarToFavorite"
         >
            <i class="fa-regular fa-heart"></i>
         </div>
         <img :src="imagePath" class="card-img-top" alt="car_image" />
         <div class="card-body">
            <div class="d-flex align-items-center">
               <p class="card-text_transmission">
                  {{ props.carItemProps.transmission === "0" ? "Số tự động" : "Số sàn" }}
               </p>
               <p class="card-text_delivery" v-if="props.carItemProps.delivery_enable === 1">
                  Giao xe tận nơi
               </p>
            </div>
            <h5 class="card-title text-uppercase">
               <span>
                  {{ props.carItemProps.carCustomName }}
               </span>
               <font-awesome-icon :icon="['fas', 'shield-halved']" style="color: #1cc88a" />
            </h5>
            <div class="info">
               <div class="desc-address d-flex">
                  <div class="d-flex align-items-center justify-content-center">
                     <font-awesome-icon icon="fa-solid fa-location-dot" />
                  </div>
                  <span>{{ props.carItemProps.location }}</span>
               </div>
            </div>
            <div class="car-item-divider"></div>
            <div class="trip-price d-flex justify-content-between align-items-center mt-3">
               <div class="trip">
                  <i class="fa-solid fa-suitcase-rolling"></i>
                  <span> {{ props.carItemProps.numberOfTrip }} </span>chuyến
               </div>
               <div class="desc-price">
                  {{ formatCurrency(props.carItemProps.price) }}
               </div>
            </div>
         </div>
      </div>
   </router-link>
</template>

<script setup>
import { formatCurrency } from "@/utils/formatCurrency.js";
import { useStore } from "vuex";
import { ref, watch } from "vue";

const props = defineProps({
   carItemProps: {
      type: Object,
      required: true,
   },
   imagePath: {
      type: String,
      required: true,
   },
});

const isFavorite = ref(false);
const store = useStore();
/**
 * TODO: Add car to favorite
 */
const addCarToFavorite = (event) => {
   const target = event.currentTarget;
   const carId = target.getAttribute("id");

   if (carId != props.carItemProps.carId) return;

   isFavorite.value = !isFavorite.value;
   target.classList.toggle("active");
   if (target.classList.contains("active")) {
      store
         .dispatch("favorite/addCar", { id: props.carItemProps.carId })
         .then((response) => {
            console.log(response);
         })
         .catch((error) => {
            console.log(error);
         });
   } else {
      store
         .dispatch("favorite/removeCar", { id: props.carItemProps.carId })
         .then((response) => {
            console.log(response);
         })
         .catch((error) => {
            console.log(error);
         });
   }
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
@import "./CarItem.scss";
</style>

<template>
   <div class="fav-item-car">
      <div class="item-box">
         <router-link
            :to="`/car/${(props.car.brand + ' ' + props.car.carName + props.car.yearOfCar)
               .toLowerCase()
               .replace(/\s+/g, '-')}/${props.car.carId}`"
         >
            <div class="img-car">
               <div class="fix-img">
                  <img :src="props.car.carImages[0].imagePath" alt="img-car" />
               </div>
            </div>
         </router-link>
         <div class="desc-car">
            <div class="desc-tag">
               <div class="tag-item transmission">
                  {{ props.car.transmission === 0 ? "Số tự động" : "Số sàn" }}
               </div>
               <div class="tag-item delivery" v-if="props.car.delivery_enable === 1">
                  Giao xe tận nơi
               </div>
            </div>
            <div class="desc-name">{{ props.car.carCustomName }}</div>
            <div class="desc-info">
               <div class="trip">
                  <i class="fa-solid fa-suitcase-rolling"></i>
                  <span> {{ props.car.numberOfTrip }} </span>chuyến
               </div>
            </div>
            <div class="desc-address">
               <i class="fa-solid fa-location-dot" />
               {{ props.car.location }}
            </div>
         </div>
         <div class="profile">
            <div class="avatar">
               <img src="../../assets/images/avatar/default.jpg" alt="" />
            </div>
            <div class="price">{{ formatCurrency(props.car.price) }}<span>/&nbsp;ngày</span></div>
            <a class="btn remove-favorite-car" @click.prevent="removeFavoriteCar">Bỏ thích</a>
            <router-link
               :to="`/car/${(props.car.brand + ' ' + props.car.carName + props.car.yearOfCar)
                  .toLowerCase()
                  .replace(/\s+/g, '-')}/${props.car.carId}`"
               class="btn btn-link"
               >Xem chi tiết</router-link
            >
         </div>
      </div>
   </div>
</template>

<script setup>
import { formatCurrency } from "@/utils/formatCurrency.js";
const emits = defineEmits(["removeFavoriteCar"]);
const props = defineProps({
   car: {
      type: Object,
      required: true,
   },
});

const removeFavoriteCar = () => {
   emits("removeFavoriteCar", props.car.carId);
};
</script>

<style scoped>
@import url("./FavoriteCarItem.scss");
</style>

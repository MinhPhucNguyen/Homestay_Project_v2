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
      <img :src="imagePath" class="card-img-top" alt="homestay_image"/>
      <div class="card-body">
        <h5 class="card-title text-uppercase">
               <span>
                  {{ props.itemProps.homestayName }}
               </span>
        </h5>
        <div class="info">
          <div class="desc-address d-flex">
            <div class="d-flex align-items-center justify-content-center">
              <font-awesome-icon icon="fa-solid fa-location-dot"/>
            </div>
            <span>{{ props.itemProps.address }}</span>
          </div>
        </div>
        <div class="review">
          <div class="rate">
            9.5
          </div>
          <div class="review-count">
            <span>Xuất sắc</span>
            <i class="fa-solid fa-circle-dot"></i>
            <span>235 Đánh giá</span>
          </div>
        </div>
        <div class="desc-price">
          <span>Bắt đầu từ</span>
          {{ formatCurrency(getLowestPrice(props.itemProps.rooms)) }}
        </div>
      </div>
    </div>
  </router-link>
</template>

<script setup>
import {formatCurrency} from "@/utils/formatCurrency.js";
import {getLowestPrice} from "@/utils/getLowestPrice.js";
import {useStore} from "vuex";
import {ref} from "vue";

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

console.log(props.itemProps);

const isFavorite = ref(false);
const store = useStore();
/**
 * TODO: Add car to favorite
 */
</script>

<style scoped>
@import "./ItemCard.scss";
</style>

<template>
   <div id="places-section" class="hidden">
      <div class="section-container">
         <h2 class="section-title">Chương trình khuyến mãi</h2>
         <h5 class="text-dark text-center fs-3 mb-4">Nhận nhiều ưu đãi hấp dẫn từ Carental</h5>

         <div class="places-carousel-wrapper">
            <i class="fa-solid fa-chevron-left" @click="arrowBtn('left')"></i>
            <ul class="places-carousel">
               <PlaceCard v-for="place in places" :key="place.id" :place="place" />
            </ul>
            <i class="fa-solid fa-chevron-right" @click="arrowBtn('right')"></i>
         </div>
      </div>
   </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import PlaceCard from "./FeaturedPlacesItem/index.vue";

const places = ref([
   {
      id: 1,
      image: "HaNoi_v2.jpg",
   },
   {
      id: 2,
      image: "HoChiMinh_v2.jpg",
   },
   {
      id: 3,
      image: "DaNang_v2.jpg",
   },
   {
      id: 4,
      image: "DaLat_v2.jpg",
   },
   {
      id: 5,
      image: "BinhDuong_v2.jpg",
   },
   {
      id: 6,
      image: "CanTho_v2.jpg",
   },
]);

const carousel = ref(null);
const firstCardWidth = ref(0);

onMounted(() => {
   carousel.value = document.querySelector(".places-carousel");
   firstCardWidth.value = carousel.value.querySelector(".places-card").offsetWidth;

   let isDragging = false,
      startX,
      startScrollLeft;

   const dragStart = (e) => {
      isDragging = true;
      carousel.value.classList.add("dragging");
      //gán startX là tọa độ X của con trỏ chuột và startScrollLeft là vị trí hiện tại của thanh cuộn để kéo thanh cuộn theo con trỏ chuột
      startX = e.pageX; //pageX là tọa độ X của con trỏ chuột
      startScrollLeft = carousel.value.scrollLeft;
   };

   const dragging = (e) => {
      if (!isDragging) return;
      carousel.value.scrollLeft = startScrollLeft - (e.pageX - startX); //pageX là tọa độ X của con trỏ chuột
   };

   const dragStop = () => {
      isDragging = false;
      carousel.value.classList.remove("dragging");
   };

   const infiniteScroll = () => {
      if (carousel.value.scrollLeft === 0) {
         document.querySelector(".fa-chevron-left").classList.add("unactive");
      } else if (
         carousel.value.scrollLeft ===
         carousel.value.scrollWidth - carousel.value.offsetWidth
      ) {
         document.querySelector(".fa-chevron-right").classList.add("unactive");
      } else {
         document.querySelector(".fa-chevron-left").classList.remove("unactive");
         document.querySelector(".fa-chevron-right").classList.remove("unactive");
      }
   };

   // carousel.value.addEventListener("mousedown", dragStart); //khi nhấn chuột thì bắt đầu kéo
   carousel.value.addEventListener("mousemove", dragging);
   document.addEventListener("mouseup", dragStop);
   carousel.value.addEventListener("scroll", infiniteScroll);
});

const arrowBtn = (direction) => {
   carousel.value.scrollLeft += direction === "left" ? -firstCardWidth.value : firstCardWidth.value;
};
</script>

<style scoped>
@import "../../../assets/styles/MainStyles/HomeStyles.scss";
@import "./FeaturedPlaces.scss";
</style>

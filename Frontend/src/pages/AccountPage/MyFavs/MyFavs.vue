<template>
   <div>
      <div class="title fs-1 fw-bold mb-4">Xe yêu thích của tôi</div>
      <div class="tab-mode d-flex align-items-center">
         <div
            class="tab-mode-item w-50"
            :class="{ active: selectedTab === 'Xe tự lái' }"
            @click="changeTab('Xe tự lái')"
         >
            Xe tự lái
         </div>
         <div
            class="tab-mode-item w-50"
            :class="{ active: selectedTab === 'Xe có tài xế' }"
            @click="changeTab('Xe có tài xế')"
         >
            Xe có tài xế
         </div>
      </div>
      <div class="list-car fav-car" v-if="favoriteCars.length > 0">
         <FavoriteCarItem
            v-for="car in favoriteCars"
            :key="car.carId"
            :car="car"
            @removeFavoriteCar="removeFavoriteCar"
         />
      </div>
      <div class="empty-car w-100" v-else>
         <img src="@/assets/images/myfavs-tab/empty-favcar.2c855700.svg" alt="empty_car" />
         <p>Không có xe yêu thích</p>
      </div>
   </div>
</template>

<script setup>
import { ref, computed } from "vue";
import { useStore } from "vuex";
import FavoriteCarItem from "@/components/FavoriteCarItem/index.vue";

const store = useStore();
const selectedTab = ref("Xe tự lái");

const changeTab = (tabName) => {
   selectedTab.value = tabName;
};

const favoriteCars = computed(() => {
   return store.getters["favorite/getFavoriteCars"];
});

/**
 * TODO: Remove favorite car
 */
const removeFavoriteCar = (carId) => {
   store.dispatch("favorite/removeCar", { id: carId });
};
</script>

<style scoped>
@import url("./MyFavs.scss");
</style>

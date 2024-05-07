<template>
   <ChangeLocationModal @change-location="changeLocation" />
   <CarTypeModal @select-car-types="selectCarTypes" />
   <CarBrandsModal @select-car-brands="selectCarBrands" :brandsList="brandsList" />
   <TransmissionsModal @select-transmission="selectTransmission" />
   <AdvancedFilterModal :featuresList="featuresList" @advanced-filter="advancedFilter" />

   <div class="finding-filter-wrapper">
      <div class="finding-section">
         <div class="m-container">
            <div class="finding-container">
               <router-link :to="{ name: 'home' }" class="back-btn" v-if="isScrollDown">
                  <i class="fa-solid fa-chevron-left"></i>
               </router-link>
               <div class="finding-info">
                  <div class="location-form" @click="openChangeLocationModal">
                     <i class="fa-solid fa-location-dot"></i>
                     <span>{{ carSearch.location }}</span>
                  </div>
                  <div class="time-form">
                     <i class="fa-regular fa-calendar"></i>
                     <!-- <span> 21:00, 03/10/2023 - 20:00, 04/10/2023</span> -->
                     <div class="time-form-container" v-if="carSearch">
                        <input type="datetime-local" class="datetime-input from-input" v-model="carSearch.startDate" />
                        <div><i class="fa-solid fa-minus text-dark"></i></div>
                        <input type="datetime-local" class="datetime-input to-input" v-model="carSearch.endDate" />
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="filter-section">
         <div class="m-container">
            <div class="filter-container">
               <div class="filter-list">
                  <div class="reset-item" :class="{ active: isFiltered }" @click="resetFilter">
                     <i class="fa-solid fa-repeat">
                        <i class="fa-solid fa-circle red-dot" v-if="isFiltered"></i>
                     </i>
                  </div>
                  <div class="swiper-list-filter">
                     <div class="swiper-slide" :class="{ active: carSearch.carTypes.length > 0 }" @click="typeCarModal">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                           <path
                              d="M19.15 15.7199H19.6C20.51 15.7199 21.24 14.8599 21.24 13.8399V12.4499C21.24 11.7199 20.86 11.0399 20.27 10.7399L18.79 9.96995L17.47 7.59994C17.09 6.90994 16.42 6.49994 15.71 6.50994H10.12C9.47 6.50994 8.86 6.84995 8.47 7.42995L6.77 9.93994L3.96 10.7999C3.24 11.0199 2.75 11.7599 2.75 12.5999V13.8299C2.75 14.8499 3.48 15.7099 4.39 15.7099H4.63"
                              stroke="black" stroke-linecap="round" stroke-linejoin="round"></path>
                           <path d="M8.87 15.7197H14.77" stroke="black" stroke-linecap="round" stroke-linejoin="round">
                           </path>
                           <path
                              d="M6.69 17.4598C7.83322 17.4598 8.76 16.5331 8.76 15.3898C8.76 14.2466 7.83322 13.3198 6.69 13.3198C5.54677 13.3198 4.62 14.2466 4.62 15.3898C4.62 16.5331 5.54677 17.4598 6.69 17.4598Z"
                              stroke="black" stroke-linecap="round" stroke-linejoin="round"></path>
                           <path
                              d="M17.08 17.4598C18.2232 17.4598 19.15 16.5331 19.15 15.3898C19.15 14.2466 18.2232 13.3198 17.08 13.3198C15.9368 13.3198 15.01 14.2466 15.01 15.3898C15.01 16.5331 15.9368 17.4598 17.08 17.4598Z"
                              stroke="black" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        <span>Loại xe</span>
                     </div>
                     <div class="swiper-slide " :class="{ active: carSearch.brandChecked > 0 }" @click="carBrandsModal">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                           <path
                              d="M21.25 11.9998C21.25 14.3198 20.39 16.4598 18.97 18.0698C17.55 19.6998 15.57 20.8298 13.33 21.1398C12.9 21.2098 12.46 21.2398 12 21.2398C11.54 21.2398 11.11 21.2098 10.67 21.1398C8.43 20.8298 6.45 19.6998 5.03 18.0698C3.61 16.4598 2.75 14.3198 2.75 11.9998C2.75 9.67977 3.61 7.53977 5.03 5.92977C6.45 4.29977 8.43 3.16977 10.67 2.85977C11.1 2.78977 11.54 2.75977 12 2.75977C12.46 2.75977 12.89 2.78977 13.33 2.85977C15.57 3.16977 17.55 4.29977 18.97 5.92977C20.39 7.53977 21.25 9.67977 21.25 11.9998Z"
                              stroke="black" stroke-linecap="round" stroke-linejoin="round"></path>
                           <path d="M11.67 21.1496C11.03 20.4796 8 17.1696 8 11.9996C8 6.82961 11.03 3.51961 11.67 2.84961"
                              stroke="black" stroke-linecap="round" stroke-linejoin="round"></path>
                           <path
                              d="M12.33 21.1496C12.97 20.4796 16 17.1696 16 11.9996C16 6.82961 12.97 3.51961 12.33 2.84961"
                              stroke="black" stroke-linecap="round" stroke-linejoin="round"></path>
                           <path d="M2.75 12H21.25" stroke="black" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg><span>Hãng xe</span>
                     </div>
                     <div class="swiper-slide" :class="{ active: carSearch.delivery }" @click="directDelivery">
                        <input type=" checkbox" id="direct-delivery" v-model="carSearch.delivery">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                           <path
                              d="M6.50511 8.86499H4.80511C3.66511 8.86499 2.74512 9.78499 2.74512 10.925V18.115C2.74512 19.255 3.66511 20.175 4.80511 20.175H19.1951C20.3351 20.175 21.2551 19.255 21.2551 18.115V10.925"
                              stroke="black" stroke-linecap="round" stroke-linejoin="round"></path>
                           <path d="M16.1154 8.86499H10.2754" stroke="black" stroke-linecap="round"
                              stroke-linejoin="round"></path>
                           <path
                              d="M16.1152 16.0549H19.1952C20.3352 16.0549 21.2552 16.9749 21.2552 18.1149C21.2552 19.2549 20.3352 20.1749 19.1952 20.1749H16.1152"
                              stroke="black" stroke-linecap="round" stroke-linejoin="round"></path>
                           <path d="M16.1152 5.7749H19.1952C20.3352 5.7749 21.2552 6.6949 21.2552 7.8349" stroke="black"
                              stroke-linecap="round" stroke-linejoin="round"></path>
                           <path d="M21.2549 18.115V7.83496" stroke="black" stroke-linecap="round" stroke-linejoin="round">
                           </path>
                           <path d="M16.1152 5.7749V16.0549" stroke="black" stroke-linecap="round" stroke-linejoin="round">
                           </path>
                           <path
                              d="M2.75488 14.0049H6.86488C7.43488 14.0049 7.89488 14.3949 7.89488 14.8849C7.89488 15.3749 8.35488 15.7649 8.92488 15.7649H9.95488C10.5249 15.7649 10.9849 16.1549 10.9849 16.6449V17.5249V20.1649"
                              stroke="black" stroke-linecap="round" stroke-linejoin="round"></path>
                           <path
                              d="M8.40495 3.82495C6.98495 3.82495 5.83496 4.97495 5.83496 6.39495C5.83496 8.15495 8.13495 10.735 8.23495 10.845C8.32495 10.945 8.48497 10.945 8.57497 10.845C8.67497 10.735 10.975 8.15495 10.975 6.39495C10.975 4.97495 9.82495 3.82495 8.40495 3.82495Z"
                              stroke="black" stroke-linecap="round" stroke-linejoin="round"></path>
                           <path
                              d="M8.40562 7.37497C8.89716 7.37497 9.29562 6.9765 9.29562 6.48497C9.29562 5.99344 8.89716 5.59497 8.40562 5.59497C7.91409 5.59497 7.51562 5.99344 7.51562 6.48497C7.51562 6.9765 7.91409 7.37497 8.40562 7.37497Z"
                              fill="black"></path>
                        </svg>
                        <span>Giao nhận xe tận nơi</span>
                     </div>
                     <div class="swiper-slide" :class="{ active: carSearch.transmission !== 'all' }"
                        @click="transmissionsModal">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                           <circle cx="18" cy="6" r="1.5" stroke="black"></circle>
                           <circle cx="18" cy="18" r="1.5" stroke="black"></circle>
                           <circle cx="12" cy="6" r="1.5" stroke="black"></circle>
                           <circle cx="12" cy="18" r="1.5" stroke="black"></circle>
                           <circle cx="6" cy="6" r="1.5" stroke="black"></circle>
                           <path
                              d="M7.57715 20V16H5.99902C5.69694 16 5.43913 16.054 5.22559 16.1621C5.01074 16.2689 4.84733 16.4206 4.73535 16.6172C4.62207 16.8125 4.56543 17.0423 4.56543 17.3066C4.56543 17.5723 4.62272 17.8008 4.7373 17.9922C4.85189 18.1823 5.0179 18.3281 5.23535 18.4297C5.4515 18.5312 5.71322 18.582 6.02051 18.582H7.07715V17.9023H6.15723C5.99577 17.9023 5.86165 17.8802 5.75488 17.8359C5.64811 17.7917 5.56868 17.7253 5.5166 17.6367C5.46322 17.5482 5.43652 17.4382 5.43652 17.3066C5.43652 17.1738 5.46322 17.0618 5.5166 16.9707C5.56868 16.8796 5.64876 16.8105 5.75684 16.7637C5.86361 16.7155 5.99837 16.6914 6.16113 16.6914H6.73145V20H7.57715ZM5.41699 18.1797L4.42285 20H5.35645L6.3291 18.1797H5.41699Z"
                              fill="black"></path>
                           <path d="M18 8V12M18 16V12M12 8V16M6 8V11.5C6 11.7761 6.22386 12 6.5 12H18" stroke="black"
                              stroke-linecap="round"></path>
                        </svg><span>Truyền động</span>
                     </div>
                     <div class="swiper-slide" :class="{ active: isElectricCar }" @click="selectElectricCar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                           <path
                              d="M19.15 19.7199H19.6C20.51 19.7199 21.24 18.8599 21.24 17.8399V16.4499C21.24 15.7199 20.86 15.0399 20.27 14.7399L18.79 13.9699L17.47 11.5999C17.09 10.9099 16.42 10.4999 15.71 10.5099H10.12C9.47 10.5099 8.86 10.8499 8.47 11.4299L6.77 13.9399L3.96 14.7999C3.24 15.0199 2.75 15.7599 2.75 16.5999V17.8299C2.75 18.8499 3.48 19.7099 4.39 19.7099H4.63"
                              stroke="black" stroke-linecap="round" stroke-linejoin="round"></path>
                           <path d="M8.87012 19.72H14.7701" stroke="black" stroke-linecap="round" stroke-linejoin="round">
                           </path>
                           <path
                              d="M6.69012 21.4598C7.83335 21.4598 8.76012 20.5331 8.76012 19.3898C8.76012 18.2466 7.83335 17.3198 6.69012 17.3198C5.54689 17.3198 4.62012 18.2466 4.62012 19.3898C4.62012 20.5331 5.54689 21.4598 6.69012 21.4598Z"
                              stroke="black" stroke-linecap="round" stroke-linejoin="round"></path>
                           <path
                              d="M17.0798 21.4598C18.223 21.4598 19.1498 20.5331 19.1498 19.3898C19.1498 18.2466 18.223 17.3198 17.0798 17.3198C15.9365 17.3198 15.0098 18.2466 15.0098 19.3898C15.0098 20.5331 15.9365 21.4598 17.0798 21.4598Z"
                              stroke="black" stroke-linecap="round" stroke-linejoin="round"></path>
                           <path d="M8 7.5H5.5V2.5H8C9.38068 2.5 10.5 3.61932 10.5 5C10.5 6.38068 9.38068 7.5 8 7.5Z"
                              stroke="black"></path>
                           <path d="M5.5 3.5H3" stroke="black" stroke-linecap="round"></path>
                           <path d="M5.5 6.5H3" stroke="black" stroke-linecap="round"></path>
                           <path d="M20 10V5H11" stroke="black" stroke-linecap="round" stroke-linejoin="round"></path>
                           <path d="M12 13L11 15H13L12 17" stroke="black" stroke-linecap="round" stroke-linejoin="round">
                           </path>
                        </svg><span>Xe điện</span>
                     </div>
                  </div>
               </div>
               <a class="btn text-black" @click.prevent="advancedFilterModal">
                  <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M12.7932 3.23242H14.1665" stroke="black" stroke-linecap="round" stroke-linejoin="round">
                     </path>
                     <path d="M1.83325 3.23242H10.0532" stroke="black" stroke-linecap="round" stroke-linejoin="round">
                     </path>
                     <path
                        d="M11.4266 4.59305C12.185 4.59305 12.7999 3.98415 12.7999 3.23305C12.7999 2.48194 12.185 1.87305 11.4266 1.87305C10.6681 1.87305 10.0532 2.48194 10.0532 3.23305C10.0532 3.98415 10.6681 4.59305 11.4266 4.59305Z"
                        stroke="black" stroke-linecap="round" stroke-linejoin="round"></path>
                     <path d="M12.7932 12.7656H14.1665" stroke="black" stroke-linecap="round" stroke-linejoin="round">
                     </path>
                     <path d="M1.83325 12.7656H10.0532" stroke="black" stroke-linecap="round" stroke-linejoin="round">
                     </path>
                     <path
                        d="M11.4266 14.1263C12.185 14.1263 12.7999 13.5174 12.7999 12.7663C12.7999 12.0151 12.185 11.4062 11.4266 11.4062C10.6681 11.4062 10.0532 12.0151 10.0532 12.7663C10.0532 13.5174 10.6681 14.1263 11.4266 14.1263Z"
                        stroke="black" stroke-linecap="round" stroke-linejoin="round"></path>
                     <path d="M5.94653 8H14.1665" stroke="black" stroke-linecap="round" stroke-linejoin="round"></path>
                     <path d="M1.83325 8H3.20658" stroke="black" stroke-linecap="round" stroke-linejoin="round"></path>
                     <path
                        d="M4.57328 9.36063C5.33175 9.36063 5.94664 8.75173 5.94664 8.00063C5.94664 7.24952 5.33175 6.64062 4.57328 6.64062C3.81481 6.64062 3.19995 7.24952 3.19995 8.00063C3.19995 8.75173 3.81481 9.36063 4.57328 9.36063Z"
                        stroke="black" stroke-linecap="round" stroke-linejoin="round"></path>
                  </svg>
                  Bộ lọc
               </a>
            </div>
         </div>
      </div>
   </div>
   <div>
      <div class="list-car-section">
         <div class="m-container">
            <div class="car-list" v-if="searchResults.length">
               <CarItem v-for=" carItem  in  searchResults " :key="carItem.carId" :carItemProps="carItem"
                  :imagePath="getImagePath(carItem.carImages)" />
            </div>
            <div class="loading" v-else-if="isLoading">
               <stateLoading />
            </div>
            <div class="non-car" v-else>
               <img src="../../assets/images/car-not-found/car-not-found.svg" alt="car-not-found" />
               <h4 class="text-center">Không tìm thấy xe nào trong khoảng thời gian này </h4>
               <h4 class="text-center">Bạn hãy chọn khoảng thời gian khác</h4>
            </div>
         </div>
      </div>
   </div>
</template>

<script setup>
import axios from "axios";
import { onMounted, ref, watch } from "vue";
import { useRouter } from "vue-router";
import CarItem from "@/components/HomeComponents/CarItemCard/CarItem.vue";
import flatpickr from "flatpickr";
import "flatpickr/dist/themes/material_green.css";
import stateLoading from "@/components/Loading/Loading.vue";
import ChangeLocationModal from "@/components/Modal/ChangeLocationModal.vue";
import CarTypeModal from "@/components/Modal/CarTypeModal.vue";
import CarBrandsModal from "@/components/Modal/CarBrandsModal.vue";
import TransmissionsModal from "@/components/Modal/TransmissionsModal.vue";
import AdvancedFilterModal from '@/components/Modal/AdvancedFilterModal.vue'
import { useStore } from "vuex";

const store = useStore();
const router = useRouter();
const searchResults = ref([]);
const isLoading = ref(false);
const isFiltered = ref(false);

const carSearch = ref({
   ...router.currentRoute.value.query,
   carTypes: [],
   brandChecked: 0,
   delivery: false,
   transmission: "all",
   fuel: "",
});

watch(carSearch.value, () => {
   console.log(carSearch.value);
})

const brandsList = ref([]);
onMounted(() => {
   store.dispatch('cars/fetchBrands').then(() => {
      brandsList.value = store.getters['cars/getBrandsList'];
   });
})

const featuresList = ref([]);
onMounted(() => {
   store.dispatch('cars/fetchFeatures').then(() => {
      featuresList.value = store.getters['cars/getFeaturesList'];
   })
})


/**
 * TODO: ADD STYLE FOR FINDING FILTER BAR
 */
const isScrollDown = ref(false);
const findingFilterBar = ref(null);
onMounted(() => {
   findingFilterBar.value = document.querySelector(".finding-filter-wrapper");
   window.addEventListener("scroll", () => {
      if (window.scrollY >= 90) {
         isScrollDown.value = true;
         findingFilterBar.value.classList.add("scroll-finding-down");
      } else {
         isScrollDown.value = false;
         findingFilterBar.value.classList.remove("scroll-finding-down");
      }
   });
});


/**
 * TODO: ADD FLATPICKR TO INPUT START & END DATE TIME 
 */
const config = {
   enableTime: true,
   dateFormat: "d/m/Y H:i",
   altInput: true,
   altFormat: "H:i,   d/m/Y",
   allowInput: true,
   defaultHour: new Date().getHours(),
};

const fromInput = ref(null);
const toInput = ref(null);
onMounted(() => {
   fromInput.value = document.querySelector(".from-input");
   toInput.value = document.querySelector(".to-input");

   const startPicker = flatpickr(fromInput.value, {
      ...config,
      defaultDate: carSearch.value.startDate,
      onChange: (selectedDates) => {
         carSearch.value.startDate = selectedDates[0];
         startPicker.close();
      },
   });
   const endPicker = flatpickr(toInput.value, {
      ...config,
      defaultDate: carSearch.value.endDate,
      onChange: (selectedDates) => {
         carSearch.value.endDate = selectedDates[0];
         endPicker.close();
      },
   });
});

/**
 * TODO: GET RESULTS SEARCH
 */
const getSearchResults = async () => {
   isLoading.value = true;

   await axios
      .post(
         "v2/search-filter-car", { ...carSearch.value }
      )
      .then(({ data }) => {
         isLoading.value = false;
         searchResults.value = data.data.cars;

      })
      .catch((error) => {
         alert(error);
      });
};
getSearchResults();

/**
 * TODO: CALL getSearchResult() WHEN VALUE change 
 */
watch(carSearch.value, () => {
   getSearchResults()
});

/**
 * TODO: HANDLE WITH IMAGE PATH
 * @param {*} carImages 
 */
const getImagePath = (carImages) => {
   if (carImages.length > 0) {
      return carImages[0].imagePath;
   }
   return null;
};

/**
 * TODO: Change location 
 */

const openChangeLocationModal = () => {
   $("#changeLocationModal").modal("show");
};

const changeLocation = (value) => {
   carSearch.value.location = value;
   $("#changeLocationModal").modal("hide");
   getSearchResults();
};

/**
 * TODO: FILTER BY CAR TYPE
 * @param {*} event 
 */
const typeCarModal = () => {
   $("#carTypeModal").modal("show");
};

const selectCarTypes = (data) => {
   carSearch.value.carTypes = data;
}

/**
 * TODO: FILTER BY BRAND
 * @param {*} event 
 */
const carBrandsModal = () => {
   $('#carBrandsModal').modal('show')
};

const selectCarBrands = (value) => {
   carSearch.value.brandChecked = value

}

/**
 * TODO: FILTER BY DIRECT DELIVERY
 */
const directDelivery = () => {
   carSearch.value.delivery = !carSearch.value.delivery
}

/**
 * TODO: FILTER BY TRANSMISSION
 */
const transmissionsModal = () => {
   $('#transmissionsModal').modal('show')
}

const selectTransmission = (value) => {
   carSearch.value.transmission = value
}

/**
 * TODO: FILTER BY ELECTRIC CAR
 */
const isElectricCar = ref(false);
const selectElectricCar = () => {
   isElectricCar.value = !isElectricCar.value;
   if (!isElectricCar.value) {
      carSearch.value.fuel = "";
      return
   }
   carSearch.value.fuel = "Electric";
}

/**
 * TODO: ADVANCED FILTER
 */
const advancedFilterModal = () => {
   $('#advancedFilterModal').modal('show');
}

const advancedFilter = (data) => {
   for (const key in data) {
      if (data.hasOwnProperty(key)) {
         const value = data[key];
         if (key === 'fuel') {
            carSearch.value.fuel = value;
         }
         else if (key === 'features') {
            carSearch.value[key] = [...value]
         }
         else {
            carSearch.value[value.name] = value;
         }
      }
   }
}

/**
 * TODO: RESET FILTER
 */
const resetFilter = () => {
   carSearch.value.location = router.currentRoute.value.query.location;
   carSearch.value.startDate = carSearch.value.startDate;
   carSearch.value.endDate = carSearch.value.startDate;
   carSearch.value.fuel = "";
   carSearch.value.carTypes = [];
   carSearch.value.brandChecked = 0;
   carSearch.value.delivery = false;
   carSearch.value.transmission = "all";
   isElectricCar.value = false;
}
</script>

<style lang="scss" scoped>
@import url("./FindCar.scss");
</style>

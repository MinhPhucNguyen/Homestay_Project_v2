<template>
   <div id="banner-section" class="hidden">
      <div class="banner">
         <!-- Banner Title -->
         <div class="banner-title">MYHOMESTAY-CÙNG BẠN TRÊN MỌI CHUYẾN ĐI</div>

         <!-- Search Options -->
         <div class="search-option">
            <!-- Search Form -->
            <div class="search shadow d-flex">
               <form action="">
                  <!-- Address Input -->
                  <div class="search-form-item address">
                     <div class="search-form-choose">
                        <!-- <i class="fa-solid fa-location-dot"></i> -->
                        <input
                           type="text"
                           class="address-input"
                           placeholder="Bạn muốn đến đâu?"
                           v-model="location"
                        />
                     </div>
                  </div>

                  <!-- Date Selection -->
                  <div class="search-form-item_divider"></div>
                  <div class="calendar-wrap d-flex">
                     <div class="search-form-item">
                        <div class="search-form-choose">
                           <input
                              type="datetime-local"
                              class="form-control datetime-picker flatpickr_start border-0 text-black"
                              placeholder="Ngày nhận"
                              v-model="startDate"
                           />
                           <div @click="openFlatPickr('start-date')">
                              <i class="fa-solid fa-chevron-down"></i>
                           </div>
                        </div>
                     </div>
                     <div class="search-form-item_divider"></div>
                     <div class="search-form-item">
                        <div class="search-form-choose">
                           <input
                              type="datetime-local"
                              class="form-control datetime-picker flatpickr_end border-0 text-black"
                              placeholder="Ngày trả"
                              v-model="endDate"
                           />
                           <div @click="openFlatPickr('end-date')">
                              <i class="fa-solid fa-chevron-down"></i>
                           </div>
                        </div>
                     </div>

                     <div class="search-form-item_divider"></div>
                     <div class="search-form-item number-of-people">
                        <div class="search-form-choose">
                           <!-- <i class="fa-regular fa-user"></i> -->
                           <input
                              type="text"
                              class="number-of-people-input"
                              placeholder="Số khách"
                              v-model="numberOfPeople"
                           />
                        </div>
                     </div>
                  </div>
                  <router-link
                     :to="{
                        name: '',
                        query: {
                           startDate: startDate,
                           endDate: endDate,
                           location: location,
                        },
                     }"
                     class="find-car-btn"
                     >Tìm</router-link
                  >
               </form>
            </div>
         </div>
      </div>
   </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import flatpickr from "flatpickr";
import "flatpickr/dist/themes/material_green.css";

const selectedOption = ref("self-drive");

const startDate = ref();
const endDate = ref();
const location = ref("");

/**
 * TODO: Add datetime picker to input
 */
onMounted(() => {
   const config = {
      dateFormat: "d/m/Y",
      altInput: true,
      altFormat: "d/m/Y",
      allowInput: true,
      defaultDate: new Date(),
   };

   flatpickr(".flatpickr_start", {
      ...config,
      defaultDate: startDate.value,
      onChange: (selectedDates) => {
         startDate.value = selectedDates[0];
      },
   });
   flatpickr(".flatpickr_end", {
      ...config,
      defaultDate: endDate.value,
      onChange: (selectedDates) => {
         endDate.value = selectedDates[0];
      },
   });
});

const openFlatPickr = (open) => {
   const startDateInput = document.querySelector(".flatpickr_start");
   const endDateInput = document.querySelector(".flatpickr_end");

   if (open === "start-date") {
      startDateInput._flatpickr.open();
   } else if (open === "end-date") {
      endDateInput._flatpickr.open();
   }
};

const changeSelectedOption = (option) => {
   selectedOption.value = option;
};
</script>

<style scoped>
@import "./Banner.scss";
</style>

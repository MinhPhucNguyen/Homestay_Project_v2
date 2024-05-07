<template>
   <my-modal @clickTo="changeLocation" idModal="changeLocationModal">
      <template v-slot:title> <span> Địa điểm </span></template>
      <div class="location-wrap-input">
         <i class="fa-solid fa-location-dot"></i>
         <input type="text" class="location-input" placeholder="Hà Nội" v-model="location" />
         <i class="fa-solid fa-circle-xmark" @click="resetInput" v-if="resetInputBtn"></i>
      </div>
      <template v-slot:buttonName>Áp dụng</template>
   </my-modal>
</template>

<script setup>
import myModal from "@/components/Modal/Modal.vue";
import { onMounted, ref, watch } from "vue";

const location = ref("");

const resetInputBtn = ref(false);
watch(location, () => {
   if (location.value == "") {
      resetInputBtn.value = false;
   } else {
      resetInputBtn.value = true;
   }
});

const resetInput = () => {
   location.value = "";
};

const emits = defineEmits(["change-location"]);
const changeLocation = () => {
   emits("change-location", location.value);
};
</script>

<style lang="scss" scoped>
.location-wrap-input {
   width: 100%;
   display: flex;
   align-items: center;
   border: 2px solid #e0e0e0;
   border-radius: 5px;
   padding: 12px;
   margin-top: 20px;

   & > i {
      font-size: 20px;
      color: #ccc;
   }

   .location-input {
      border: 0;
      height: 100%;
      margin-left: 7px;
      font-size: 20px;
      flex: 1;
      padding: 5px;
      outline: none;
      border-color: transparent;
   }

   .fa-circle-xmark {
      color: rgb(242, 106, 43);
      cursor: pointer;
   }
}
</style>

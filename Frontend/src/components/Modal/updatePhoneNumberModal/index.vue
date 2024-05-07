<template>
   <my-modal @clickTo="updateAndVerifyPhoneNumber" idModal="updatePhoneNumberModal">
      <template v-slot:title> <span> Cập nhật số điện thoại </span></template>
      <div v-if="props.isLoading" class="w-100 d-flex justify-content-center mt-3 mb-4">
         <div class="spinner-grow text-success" role="status" style="width: 30px; height: 30px">
            <span class="visually-hidden">Loading...</span>
         </div>
      </div>
      <div v-if="props.isUpdatePhoneSuccess && props.successMessage">
         <p class="text-center fs-5 mt-3 mb-0">{{ props.successMessage }}</p>
      </div>
      <div v-else class="custom-input mt-4">
         <div class="wrap-input w-100">
            <input
               type="text"
               name="ip_displayname"
               placeholder="Số điện thoại"
               v-model="model.phone"
            />
         </div>
         <small class="text-danger" v-if="props.errors">{{ props.errors }}</small>
      </div>
      <template v-slot:buttonName>
         <span v-if="props.isUpdatePhoneSuccess"> Xác minh ngay </span>
         <span v-else> Cập nhật </span>
      </template>
   </my-modal>
</template>

<script setup>
import myModal from "@/components/Modal/Modal.vue";
import { ref, onMounted } from "vue";

const model = ref({
   phone: null,
});
const props = defineProps([
   "user",
   "errors",
   "isLoading",
   "isUpdatePhoneSuccess",
   "successMessage",
]);
const emits = defineEmits(["update-phone-number"]);

const updateAndVerifyPhoneNumber = () => {
   if (props.isUpdatePhoneSuccess) {
      emits("update-phone-number", { phone: model.value.phone, isVerify: true });
   } else {
      updatePhoneNumber();
   }
};

const updatePhoneNumber = () => {
   emits("update-phone-number", model.value);
};

onMounted(() => {
   $("#updatePhoneNumberModal").on("hide.bs.modal", () => {
      model.value = {
         phone: null,
      };
   });
});
</script>

<style></style>

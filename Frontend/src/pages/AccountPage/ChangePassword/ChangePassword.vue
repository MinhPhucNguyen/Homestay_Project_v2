<template>
   <ToastMessage
      :message="successMessage ? successMessage : errorMessage"
      :toastType="errorMessage ? 'danger' : 'success'"
   />
   <div class="content-title">
      <h4 class="fs-1 fw-bold">Đổi mật khẩu</h4>
      <p class="fs-5 mb-0">Vui lòng nhập mật khẩu hiện tại của bạn để thay đổi mật khẩu</p>
   </div>
   <div class="content-item change-pw">
      <div class="title fs-3 text-black mb-4">Nhập mật khẩu</div>
      <div class="content">
         <form @submit.prevent="changePassword" v-if="model">
            <div class="custom-input mb-4">
               <div class="wrap-info fw-bold mb-1">Mật khẩu hiện tại</div>
               <div class="wrap-input w-100">
                  <input type="password" name="oldPassword" v-model="model.oldPassword" />
                  <i
                     class="fa-regular fa-eye-slash fs-5"
                     @click="showPw($refs.eye1)"
                     ref="eye1"
                  ></i>
               </div>
               <small class="text-danger">
                  <span v-if="errors.oldPassword">{{ errors.oldPassword[0] }}</span>
               </small>
            </div>
            <div class="custom-input mb-4">
               <div class="wrap-info fw-bold mb-1">Mật khẩu mới</div>
               <div class="wrap-input w-100">
                  <input type="password" name="newPassword" v-model="model.newPassword" />
                  <i
                     class="fa-regular fa-eye-slash fs-5"
                     @click="showPw($refs.eye2)"
                     ref="eye2"
                  ></i>
               </div>
               <small class="text-danger" v-if="errors.newPassword">
                  {{ errors.newPassword[0] }}</small
               >
            </div>
            <div class="custom-input mb-4">
               <div class="wrap-info fw-bold mb-1">Xác nhận mật khẩu mới</div>
               <div class="wrap-input w-100">
                  <input
                     type="password"
                     name="newPasswordConfirmation"
                     v-model="model.newPasswordConfirmation"
                  />
                  <i
                     class="fa-regular fa-eye-slash fs-5"
                     @click="showPw($refs.eye3)"
                     ref="eye3"
                  ></i>
               </div>
               <small class="text-danger" v-if="errors.newPasswordConfirmation">
                  {{ errors.newPasswordConfirmation[0] }}</small
               >
            </div>
            <div class="confirm-button">
               <button
                  type="submit"
                  class="btn btn-success d-flex justify-content-center"
                  style="width: 150px"
               >
                  <div
                     class="spinner-grow"
                     role="status"
                     style="width: 24px; height: 24px"
                     v-if="isLoading"
                  >
                     <span class="visually-hidden">Loading...</span>
                  </div>
                  <span v-if="!isLoading">Xác nhận</span>
               </button>
            </div>
         </form>
      </div>
   </div>
</template>

<script setup>
import { computed, ref } from "vue";
import { useStore } from "vuex";
import axios from "axios";
import ToastMessage from "@/components/Toast/index.vue";

const model = ref({
   oldPassword: "",
   newPassword: "",
   newPasswordConfirmation: "",
});
const store = useStore();
const isLoading = ref(false);
const successMessage = ref(null);
const errors = ref({});

const resetForm = () => {
   model.value = {
      oldPassword: "",
      newPassword: "",
      newPasswordConfirmation: "",
   };
   errors.value = {};
};

const user = computed(() => store.getters["auth/getUser"]);
const id = user.value.id;

const errorMessage = ref(null);
const changePassword = async () => {
   isLoading.value = true;
   await axios
      .post(`v2/users/${id}/change-password`, model.value)
      .then((response) => {
         errorMessage.value = null;
         isLoading.value = false;
         successMessage.value = response.data.message;
         $(".toast").toast("show");
         resetForm();
      })
      .catch((error) => {
         if (error.response.status === 400) {
            errorMessage.value = error.response.data.message;
            isLoading.value = false;
            successMessage.value = null;
            $(".toast").toast("show");
            model.value.oldPassword = "";
         }
         if (error.response.status === 422) {
            isLoading.value = false;
            successMessage.value = null;
            errorMessage.value = null;
            errors.value = error.response.data.errors;
         }
      });
};

/**
 * TODO: SHOW/HIDE PASSWORD
 */
const showPw = (icon) => {
   const input = icon.previousSibling;
   if (input.type === "password") {
      input.type = "text";
      icon.classList.remove("fa-eye-slash");
      icon.classList.add("fa-eye");
   } else {
      input.type = "password";
      icon.classList.remove("fa-eye");
      icon.classList.add("fa-eye-slash");
   }
};
</script>

<style scoped>
@import url("./ChangePassword.scss");
</style>

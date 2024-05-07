<template>
   <div class="w-100 d-flex align-items-center justify-content-center" v-if="redirectToLogin">
      <div class="spinner-grow text-success" style="width: 4rem; height: 4rem" role="status">
         <span class="visually-hidden">Loading...</span>
      </div>
   </div>
   <div class="col-md-4 mx-auto">
      <div class="card" style="margin-top: 100px">
         <div class="card-header text-center bg-white border-0 mt-4">
            <h3 class="text-black fw-bold">Đặt lại mật khẩu</h3>
         </div>
         <div class="card-body mx-auto pt-0" style="width: 500px">
            <form @submit.prevent="resetPassword" id="login-form">
               <div class="mt-4 text-success text-center" v-if="successMessage">
                  <i class="fa-regular fa-circle-check mb-4" style="font-size: 60px"></i>
                  <p class="fw-bold fs-4">{{ successMessage }}</p>
               </div>
               <div v-else>
                  <div class="mt-1 text-danger text-center" v-if="errorMessage">
                     <i class="fa-regular fa-circle-xmark mb-3" style="font-size: 30px"></i>
                     <p class="fw-bold fs-6">{{ errorMessage }}</p>
                  </div>
                  <div class="form-group row mb-1 mt-4">
                     <label for="" class="fw-bold">Email</label>
                     <div class="col-md-12">
                        <input
                           type="text"
                           class="form-control reset-pw-input p-2"
                           v-model="model.email"
                        />
                        <small class="text-danger" v-if="errors.email">{{ errors.email[0] }}</small>
                     </div>
                  </div>
                  <div class="form-group row mb-1 mt-4">
                     <label for="" class="fw-bold">Mật khẩu</label>
                     <div class="col-md-12">
                        <input
                           type="password"
                           class="form-control reset-pw-input p-2"
                           v-model="model.password"
                        />
                        <small class="text-danger" v-if="errors.password">{{
                           errors.password[0]
                        }}</small>
                     </div>
                  </div>
                  <div class="form-group row mb-1 mt-4">
                     <label for="" class="fw-bold">Nhập lại mật khẩu</label>
                     <div class="col-md-12">
                        <input
                           type="password"
                           class="form-control reset-pw-input p-2"
                           v-model="model.password_confirmation"
                        />
                        <small class="text-danger" v-if="errors.password_confirmation">{{
                           errors.password_confirmation[0]
                        }}</small>
                     </div>
                  </div>
                  <div class="form-group row mb-3 mt-4">
                     <div class="col-md-12">
                        <button
                           type="submit"
                           class="btn btn-lg p-3 w-100 fw-bold text-white d-flex justify-content-center align-items-center continue-btn"
                           :disabled="!isFilledForm"
                        >
                           <div
                              class="spinner-grow text-light"
                              v-if="isLoading"
                              style="width: 2rem; height: 2rem"
                              role="status"
                           >
                              <span class="visually-hidden">Loading...</span>
                           </div>
                           <span v-if="!isLoading">Đặt lại mật khẩu</span>
                        </button>
                     </div>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</template>

<script setup>
import { ref, watch } from "vue";
import { useRouter } from "vue-router";
import { useStore } from "vuex";

const model = ref({
   email: "",
   password: "",
   password_confirmation: "",
});
const store = useStore();
const router = useRouter();
const isFilledForm = ref(false);
const errors = ref({});
const isLoading = ref(false);
const successMessage = ref(null);
const errorMessage = ref(null);

watch(model.value, (value) => {
   isFilledForm.value = true;
   if (value.email === "" || value.password === "" || value.password_confirmation === "") {
      errors.value = {};
   }
});

const redirectToLogin = ref(false);
const resetPassword = () => {
   isLoading.value = true;
   store
      .dispatch("auth/resetPassword", {
         ...model.value,
         token: router.currentRoute.value.query.token,
      })
      .then((response) => {
         successMessage.value = response.data.message;
         errorMessage.value = null;
         isLoading.value = false;
         setTimeout(() => {
            redirectToLogin.value = true;
            setTimeout(() => {
               router.push({ name: "login" });
            }, 2000);
         }, 500);
      })
      .catch((error) => {
         console.log(error);
         if (error.response.status === 422) {
            errors.value = error.response.data.errors;
            isLoading.value = false;
         } else if (error.response.status === 500) {
            errorMessage.value = error.response.data.message;
            successMessage.value = null;
            isLoading.value = false;
         }
      });
};
</script>

<style lang="scss" scoped>
.reset-pw-input {
   height: 50px;
   outline: none;
}
.continue-btn {
   background: #1cc88a;

   &:hover {
      background: #26b480;
   }
}
</style>

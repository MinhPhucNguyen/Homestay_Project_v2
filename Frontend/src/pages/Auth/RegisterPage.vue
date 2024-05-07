<template>
   <div class="col-md-4 mx-auto mb-4">
      <div class="card">
         <div class="card-header text-center bg-white border-0 mt-4">
            <h3 class="text-black fw-bold">Đăng ký</h3>
         </div>
         <div class="card-body pt-0">
            <form @submit.prevent="registerSubmit()" class="row" id="register-form">
               <div class="form-group col-md-6 mb-2">
                  <label for="firstname" class="fw-bold mb-0">Tên</label>
                  <div class="col-md-12 p-0">
                     <input
                        v-model="formRegister.firstname"
                        type="text"
                        class="form-control"
                        id="firstname"
                        @input="clearError('firstname')"
                     />
                     <small v-if="errors.firstname" class="text-danger">
                        {{ errors.firstname[0] }}
                     </small>
                  </div>
               </div>
               <div class="form-group col-md-6 mb-2">
                  <label for="lastname" class="fw-bold mb-0">Họ</label>
                  <div class="col-md-12 p-0">
                     <input
                        v-model="formRegister.lastname"
                        type="text"
                        class="form-control"
                        id="lastname"
                        @input="clearError('lastname')"
                     />
                     <small v-if="errors.lastname" class="text-danger">
                        {{ errors.lastname[0] }}
                     </small>
                  </div>
               </div>
               <div class="form-group col-md-6 mb-2">
                  <label for="username" class="fw-bold mb-0">Tên đăng nhập</label>
                  <div class="col-md-12 p-0">
                     <input
                        v-model="formRegister.username"
                        type="text"
                        class="form-control"
                        @input="clearError('username')"
                     />
                     <small v-if="errors.username" class="text-danger">
                        {{ errors.username[0] }}
                     </small>
                  </div>
               </div>

               <div class="form-group col-md-6 mb-2">
                  <label for="phone" class="fw-bold mb-0">Số điện thoại</label>
                  <div class="col-md-12 p-0">
                     <input
                        v-model="formRegister.phone"
                        type="text"
                        class="form-control"
                        @input="clearError('phone')"
                     />
                     <small v-if="errors.phone" class="text-danger">
                        {{ errors.phone[0] }}
                     </small>
                  </div>
               </div>

               <div class="form-group mb-2">
                  <label for="email" class="fw-bold mb-0">Email</label>
                  <div class="col-md-12 p-0">
                     <input
                        v-model="formRegister.email"
                        type="text"
                        class="form-control"
                        @input="clearError('email')"
                     />
                     <small v-if="errors.email" class="text-danger">
                        {{ errors.email[0] }}
                     </small>
                  </div>
               </div>
               <div class="form-group col-md-6 mb-4">
                  <label for="password" class="fw-bold mb-0">Mật khẩu</label>
                  <div class="col-md-12 p-0">
                     <input
                        v-model="formRegister.password"
                        type="password"
                        class="form-control"
                        @input="clearError('password')"
                     />
                     <small v-if="errors.password" class="text-danger">
                        {{ errors.password[0] }}
                     </small>
                  </div>
               </div>

               <div class="form-group col-md-6 mb-4">
                  <label for="confirm_password" class="fw-bold mb-0">Nhập lại mật khẩu</label>
                  <div class="col-md-12 p-0">
                     <input
                        v-model="formRegister.confirm_password"
                        type="password"
                        class="form-control"
                        @input="clearError('confirm_password')"
                     />
                     <small v-if="errors.confirm_password" class="text-danger">
                        {{ errors.confirm_password[0] }}
                     </small>
                  </div>
               </div>
               <div class="form-group mb-2">
                  <div class="col-md-12 p-0">
                     <button
                        type="submit"
                        class="btn btn-lg p-3 fw-bold text-white mb-4 signup-btn d-flex aligns-items-center justify-content-center"
                        name="register-btn"
                     >
                        <div
                           class="spinner-grow text-light"
                           v-if="isLoading"
                           style="width: 2rem; height: 2rem"
                           role="status"
                        >
                           <span class="visually-hidden">Loading...</span>
                        </div>
                        <span v-else> Đăng ký </span>
                     </button>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</template>

<script setup>
import { ref } from "vue";
import { useStore } from "vuex";
import { useRouter } from "vue-router";

const store = useStore();
const formRegister = ref({
   firstname: "",
   lastname: "",
   username: "",
   password: "",
   phone: "",
   email: "",
   confirm_password: "",
});
const errors = ref({});
const router = useRouter();
const isLoading = ref(false);

const registerSubmit = () => {
   isLoading.value = true;
   store
      .dispatch("auth/register", formRegister.value)
      .then(() => {
         router.push({ name: "home" });
         isLoading.value = false;
      })
      .catch((e) => {
         console.log(e);
         isLoading.value = false;
         errors.value = e.response.data.errors;
      });
};

const clearError = (field) => {
   delete errors.value[field];
};
</script>

<style scoped>
input:not([type="radio"]) {
   height: 50px;
   outline: none;
}

.card-body {
   margin-top: 5px;
}
input[type="radio"]:checked {
   background-color: #1cc88a;
   border-color: #1cc88a;
}
.signup-btn {
   width: 100%;
   background: #1cc88a;
}
.signup-btn:hover {
   background: #26b480;
}
</style>

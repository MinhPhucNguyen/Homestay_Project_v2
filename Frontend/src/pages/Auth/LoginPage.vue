<template>
   <div class="col-md-4 mx-auto">
      <div class="card" style="margin-top: 100px">
         <div class="card-header text-center bg-white border-0 mt-4">
            <h3 class="text-black fw-bold" style="font-family: 'Montserrat', sans-serif">
               Đăng nhập
            </h3>
         </div>
         <div class="card-body mx-auto pt-0" style="width: 500px">
            <div class="mt-1 text-danger text-center" v-if="errors && errors.global">
               <i class="fa-regular fa-circle-xmark mb-3" style="font-size: 30px"></i>
               <p class="fw-bold fs-6">{{ errors.global }}</p>
            </div>
            <form @submit.prevent="loginSubmit()" id="login-form">
               <div class="form-group row mb-2">
                  <label for="email" class="fw-bold">Email</label>
                  <div class="col-md-12">
                     <input
                        id="email"
                        type="text"
                        class="form-control login-input p-2"
                        :class="{ 'is-invalid': errors && errors.email }"
                        v-model="credentials.email"
                        @input="clearError('email')"
                        autofocus
                     />
                     <small v-if="errors && errors.email" class="text-danger">
                        {{ errors.email[0] }}
                     </small>
                  </div>
               </div>
               <div class="form-group row mb-1 mt-4">
                  <label for="password" class="fw-bold">Mật khẩu</label>
                  <div class="col-md-12">
                     <input
                        id="password"
                        type="password"
                        class="form-control login-input p-2"
                        :class="{ 'is-invalid': errors && errors.password }"
                        v-model="credentials.password"
                        @input="clearError('password')"
                        autofocus
                     />
                     <small v-if="errors && errors.password" class="text-danger">
                        {{ errors.password[0] }}
                     </small>
                  </div>
               </div>
               <p class="mt-2" style="text-align: right">
                  <router-link
                     :to="{ name: 'forgotPassword' }"
                     style="color: #1cc88a; text-decoration: none"
                     class="fw-bold"
                     >Quên Mật khẩu?</router-link
                  >
               </p>
               <div class="form-group row mb-3">
                  <div class="col-md-12">
                     <button
                        type="submit"
                        class="btn btn-lg p-3 w-100 fw-bold text-white d-flex justify-content-center align-items-center login-btn"
                     >
                        <div
                           class="spinner-grow text-light"
                           v-if="isLoading"
                           style="width: 2rem; height: 2rem"
                           role="status"
                        >
                           <span class="visually-hidden">Loading...</span>
                        </div>
                        <span v-else> Đăng nhập </span>
                     </button>
                  </div>
               </div>
            </form>
            <div class="form-group mb-0 d-flex justify-content-center">
               <p class="text-secondary">
                  Bạn chưa là thành viên ?
                  <router-link
                     to="/register"
                     class="fw-bold text-decoration-none"
                     style="color: #1cc88a"
                     >Đăng ký ngay</router-link
                  >
               </p>
            </div>
            <div class="socialite-container mt-4 mb-4">
               <div class="title d-flex align-items-center justify-content-between">
                  <div class="border-text"></div>
                  <div class="d-inline-block fw-bold">Hoặc đăng nhập với tài khoản</div>
                  <div class="border-text"></div>
               </div>
               <div class="socialite-btn mt-4">
                  <a class="border border-1" @click.prevent="loginWithFacebook"
                     ><img src="../../assets/images/social-logo/facebook.png" alt="" /> Facebook
                  </a>
                  <a class="border border-1" @click.prevent="loginWithGoogle"
                     ><img src="../../assets/images/social-logo/google.png" alt="" /> Google
                  </a>
               </div>
            </div>
         </div>
      </div>
   </div>
</template>

<script setup>
import { ref } from "vue";
import { useStore } from "vuex";
import { useRouter } from "vue-router";

const store = useStore();
const credentials = ref({
   email: "",
   password: "",
});
const isLoading = ref(false);
const errors = ref(null);
const router = useRouter();

const loginSubmit = () => {
   isLoading.value = true;
   store
      .dispatch("auth/login", credentials.value)
      .then(() => {
         isLoading.value = false;
         store.getters["auth/getUser"] && store.getters["auth/isAdmin"]
            ? router.push({ name: "admin.dashboard" })
            : router.push({ name: "home" });
      })
      .catch((e) => {
         if (e) {
            errors.value = e.response.data.errors;
            if (!errors.value.email && !errors.value.password) {
               errors.value = { global: e.response.data.errors };
            }
            isLoading.value = false;
         }
      });
};

const clearError = (field) => {
   if (errors.value) {
      delete errors.value[field];
      errors.value = null;
   }
};

const loginWithGoogle = () => {
   store.dispatch("auth/loginWithGoogle").then((response) => {
      if (response.data.url) {
         window.location.href = response.data.url;
      }
   });
};

const loginWithFacebook = () => {
   store.dispatch("auth/loginWithFacebook").then((response) => {
      if (response.data.url) {
         window.location.href = response.data.url;
      }
   });
};
</script>

<style lang="scss" scoped>
.login-input {
   height: 50px;
   outline: none;
}
.login-btn {
   background: #1cc88a;

   &:hover {
      background: #26b480;
   }
}

.border-text {
   height: 1px;
   min-width: 20%;
   background: #e3e6f0;
}

.socialite-btn {
   display: flex;
   justify-content: space-between;
   gap: 18px;
   grid-gap: 18px;

   a {
      width: 50%;
      padding: 14px 48px;
      font-size: 16px;
      text-decoration: none;
      color: black;
      font-weight: 500;
      border-radius: 6px;
      text-align: center;
      cursor: pointer;

      img {
         width: 20px;
         height: 20px;
         object-fit: cover;
         margin-right: 8px;
      }
   }

   a:hover {
      transition: 0.2s all ease-in-out;
      box-shadow: 0 0 0 2px #21e09ab0;
   }
}
</style>

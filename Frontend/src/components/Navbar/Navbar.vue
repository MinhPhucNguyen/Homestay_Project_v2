<template>
   <nav class="navbar navbar-expand-lg">
      <div class="navbar-container text-black p-0 d-flex">
         <router-link to="/" class="navbar-brand fw-bold text-uppercase fs-4" href="/">
            <span style="color: #1cc88a">MY</span>HOMESTAY
         </router-link>
         <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="{{ __('Toggle navigation') }}"
         >
            <span class="navbar-toggler-icon"></span>
         </button>

         <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
               <li class="nav-item">
                  <router-link to="/about" class="nav-link text-black" href=""
                     >Về Chúng tôi</router-link
                  >
               </li>
               <li class="nav-item">
                  <router-link to="/blog" class="nav-link text-black">Blog</router-link>
               </li>
               <li class="nav-item">
                  <span class="nav-item-border"></span>
               </li>

               <!-- Authentication Links -->
               <div class="authentication-container d-flex">
                  <router-link
                     v-if="isAuthenticated"
                     to="/account"
                     id="user-info"
                     class="text-black fw-bold text-decoration-none"
                  >
                     <div class="d-flex align-items-center" v-if="user">
                        <img class="avatar-image" :src="user.avatar" alt="avatar" />
                        <span class="mr-3">{{ user.fullname ?? user.username }}</span>
                        <i class="fa-solid fa-angle-down"></i>
                     </div>
                     <div
                        v-else
                        class="spinner-grow text-success"
                        role="status"
                        style="width: 20px; height: 20px"
                     >
                        <span class="visually-hidden">Loading...</span>
                     </div>
                  </router-link>
                  <ul v-else>
                     <li id="register-btn" class="nav-item m-0">
                        <router-link to="/register" class="nav-link text-black btn"
                           >Đăng ký</router-link
                        >
                     </li>
                     <li id="login-btn" class="nav-item border border-dark rounded-3">
                        <router-link to="/login" class="nav-link text-black btn"
                           >Đăng nhập</router-link
                        >
                     </li>
                  </ul>
               </div>
            </ul>
         </div>
      </div>
   </nav>
</template>

<script setup>
import { computed, onMounted, ref } from "vue";
import { useRouter } from "vue-router";
import { useStore } from "vuex";

const store = useStore();
const isAuthenticated = computed(() => store.getters["auth/isAuthenticated"]);
const navbar = ref(null);
const user = computed(() => store.getters["users/getUserById"]);
const router = useRouter();

onMounted(() => {
   navbar.value = document.querySelector(".navbar");
   window.addEventListener("scroll", () => {
      if (window.scrollY >= 90) {
         navbar.value.classList.add("navbar-scroll-down");
      } else {
         navbar.value.classList.remove("navbar-scroll-down");
      }
   });
});
</script>

<style lang="scss" scoped>
@import "./Navbar.scss";
</style>

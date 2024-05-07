<template>
   <MainNavbar v-if="!$route.meta.hideNavbar" />
   <main class="main">
      <div class="content-container">
         <router-view></router-view>
      </div>
   </main>
   <MainFooter v-if="!$route.meta.hideFooter" />
</template>

<script setup>
import MainNavbar from "@/components/Navbar/Navbar.vue";
import MainFooter from "@/components/Footer/Footer.vue";
</script>

<style scoped>
.main {
   padding-top: 90px;
}
</style>

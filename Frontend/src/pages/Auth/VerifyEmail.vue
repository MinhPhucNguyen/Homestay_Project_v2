<template>
   <div class="w-100 d-flex justify-content-center mt-4 loading">
      <div
         class="spinner-grow text-success"
         role="status"
         style="width: 65px; height: 65px"
         v-if="isLoading"
      >
         <span class="visually-hidden">Loading...</span>
      </div>
   </div>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import { useStore } from "vuex";

const store = useStore();
const router = useRouter();
const isLoading = ref(true);

store
   .dispatch("users/verifyEmail", router.currentRoute.value.query)
   .then(() => {
      isLoading.value = false;
   })
   .then(() => {
      router.push({ name: "accountContent" });
   });
</script>

<style scoped>
.loading {
   position: absolute;
   top: 30%;
   left: 50%;
   transform: translate(-50%, -50%);
}
</style>

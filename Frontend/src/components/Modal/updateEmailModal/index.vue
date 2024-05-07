<template>
   <my-modal @clickTo="handleEmail" idModal="updateEmailModal" :showButton="showButton">
      <template v-slot:title>Cập nhật Email</template>
      <div class="w-100 d-flex justify-content-center mt-3 mb-4">
         <div
            class="spinner-grow text-success"
            role="status"
            style="width: 30px; height: 30px"
            v-if="props.isLoading"
         >
            <span class="visually-hidden">Loading...</span>
         </div>
      </div>
      <div v-if="props.isUpdateEmailSuccess && props.successMessage">
         <p class="text-center fs-5 mt-3 mb-0">
            {{ props.checkEmail ? props.checkEmail : props.successMessage }}
         </p>
      </div>
      <div v-else class="custom-input mt-4">
         <div class="wrap-input w-100">
            <input
               type="text"
               name="ip_displayname"
               placeholder="Email mới"
               v-model="model.email"
            />
         </div>
         <small class="text-danger" v-if="props.errors">{{ props.errors }}</small>
      </div>
      <template v-slot:buttonName>
         <span v-if="props.isUpdateEmailSuccess"> Xác minh ngay </span>
         <span v-else> Cập nhật </span>
      </template>
      <template v-slot:message>
         <div v-if="props.checkEmail" class="text-center fs-6 mt-2 mb-3 mb-0 mx-auto">
            Không nhận được email.
            <span class="fs-6 resend-btn" style="cursor: pointer" @click="verificationEmail"
               >Yêu cầu gửi lại</span
            >
         </div>
      </template>
   </my-modal>
</template>

<script setup>
import myModal from "@/components/Modal/Modal.vue";
import { onMounted, ref } from "vue";

const props = defineProps([
   "user",
   "isLoading",
   "errors",
   "successMessage",
   "isUpdateEmailSuccess",
   "checkEmail",
]);

const model = ref({
   email: "",
});

const emits = defineEmits(["handle-email"]);

const handleEmail = () => {
   if (props.isUpdateEmailSuccess) {
      verificationEmail();
   } else {
      updateEmail();
   }
};
const updateEmail = () => {
   emits("handle-email", model.value);
};

const showButton = ref(true);
const verificationEmail = () => {
   showButton.value = false;
   emits("handle-email", props.isUpdateEmailSuccess);
};

onMounted(() => {
   $("#updateEmailModal").on("hide.bs.modal", () => {
      model.value.email = "";
      showButton.value = true;
   });
});
</script>

<style scoped>
.resend-btn {
   color: #1cc88a;
}
.resend-btn:hover {
   color: #2ddd9da1;
   transition: all 0.2s ease-in-out;
}
</style>

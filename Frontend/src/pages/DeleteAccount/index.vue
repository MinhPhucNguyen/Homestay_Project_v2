<template>
   <MyModal @clickTo="handleDeleteAccount" idModal="deleteAccountModal">
      <template v-slot:title>{{ isDeleteAccountSuccess ? "Thông báo" : "Xác nhận" }}</template>
      <h6 class="text-dark text-center fs-5 mt-4">
         {{
            isDeleteAccountSuccess
               ? "Yêu cầu xóa tài khoản thành công."
               : "Bạn có chắc chắn muốn xóa tài khoản?"
         }}
      </h6>
      <template v-slot:buttonName>
         <div
            class="spinner-grow text-white"
            role="status"
            style="width: 30px; height: 30px"
            v-if="isLoading"
         >
            <span class="visually-hidden">Loading...</span>
         </div>
         <span v-else>
            {{ isDeleteAccountSuccess ? "Đóng" : "Tiếp tục" }}
         </span>
      </template>
   </MyModal>

   <div class="delete-account-section">
      <div class="delete-account-container flex-column text-center">
         <h2 class="fw-bold">Yêu cầu xóa tài khoản</h2>
         <div class="delete-account-image">
            <img src="../../assets/images/delete-account/delete-account.svg" alt="" />
         </div>
         <div class="content-inner d-inline-block">
            <p>Khi xóa tài khoản, các thông tin sau (nếu có) sẽ bị xóa trên hệ thống:</p>
            <ul>
               <li>Thông tin cá nhân</li>
               <li>Thông tin lịch sử chuyến và danh sách xe</li>
            </ul>
            <p>
               Tiền ví và điểm thưởng sẽ được thanh toán theo quy định và chính sách hiện hành của
               Mioto.
            </p>

            <p>
               Việc đồng ý xóa tài khoản là bạn đã chấp nhận điều khoản chính sách xóa tài khoản của
               Mioto.
            </p>

            <p>
               Yêu cầu xóa tài khoản sẽ được xử lý trong vòng 15 ngày làm việc. Mioto sẽ liên hệ
               trực tiếp với bạn thông qua Email hoặc Số điện thoại đã cung cấp.
            </p>

            <p>
               Mọi thắc mắc xin liên hệ Fanpage của Mioto hoặc Hotline 1900 9217 (7AM - 10PM) để
               được hỗ trợ.
            </p>
         </div>
         <div class="wrap-btn d-flex flex-column">
            <a @click.prevent="deleteAccountConfirm" class="btn btn-danger del-account-btn fw-bold"
               >Xóa tài khoản</a
            >
            <router-link :to="{ name: 'home' }" class="cancel-btn text-dark mt-2 fw-bold"
               >Hủy</router-link
            >
         </div>
      </div>
   </div>
</template>

<script setup>
import { onBeforeMount, onMounted, ref } from "vue";
import { useStore } from "vuex";
import MyModal from "@/components/Modal/Modal.vue";
import { useRouter } from "vue-router";

const router = useRouter();
const store = useStore();
const isLoading = ref(false);
const isDeleteAccountSuccess = ref(false);

/**
 * TODO: Open modal to confirm delete account
 */
const deleteAccountConfirm = () => {
   $("#deleteAccountModal").modal("show");
};

const handleDeleteAccount = () => {
   if (isDeleteAccountSuccess.value) {
      router.push({ name: "home" });
      $("#deleteAccountModal").modal("hide");
   } else {
      deleteAccount();
   }
};

const deleteAccount = () => {
   isLoading.value = true;
   store
      .dispatch("users/deleteAccount", store.getters["auth/getUser"].id)
      .then(() => {
         isLoading.value = false;
         isDeleteAccountSuccess.value = true;
      })
      .catch((error) => {
         alert(error);
      });
};

onMounted(() => {
   $("#deleteAccountModal").on("hide.bs.modal", () => {
      if (isDeleteAccountSuccess.value) {
         router.go({ name: "home" });
      }
   });
});
</script>

<style scoped>
@import url("./deleteAccount.scss");
</style>

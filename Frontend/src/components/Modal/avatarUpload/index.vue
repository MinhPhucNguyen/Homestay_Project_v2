<template>
   <div
      class="modal fade"
      id="avatarModal"
      tabindex="-1"
      aria-labelledby="avatarModalLabel"
      aria-hidden="true"
   >
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header border-0">
               <button
                  type="button"
                  class="btn-close border border-3 rounded-circle"
                  data-bs-dismiss="modal"
                  aria-label="Close"
                  @click="closeModal"
               ></button>
            </div>
            <div class="modal-body text-center">
               <h1 class="modal-title fs-3 text-center" id="avatarModalLabel">
                  Cập nhật ảnh đại diện
               </h1>
               <input type="file" name="ip_upload_avatar" class="d-none" @change="imageChange" />
               <button
                  type="button"
                  class="btn btn-primary choose-avatar-btn hover-shadow rounded-pill border-0 text-uppercase"
                  style="
                     margin: 40px auto;
                     background: #1cc88a;
                     padding: 16px 24px;
                     font-weight: 500;
                  "
                  @click="uploadAvatar"
               >
                  Chọn hình
               </button>
               <div v-if="imageUrl" class="new-avatar-container mt-2">
                  <img :src="imageUrl" alt="" class="avatar" />
                  <a
                     class="btn btn-danger fw-bold w-100 p-3 border-0 fs-5"
                     style="background: #1cc88a"
                     @click.prevent="handleChangeAvatar"
                  >
                     <div
                        class="spinner-grow"
                        role="status"
                        style="width: 24px; height: 24px"
                        v-if="props.isLoading"
                     >
                        <span class="visually-hidden">Loading...</span>
                     </div>
                     <span v-if="!props.isLoading"> Cập nhật </span>
                  </a>
               </div>
            </div>
         </div>
      </div>
   </div>
</template>

<script setup>
import { onMounted, ref } from "vue";

const emits = defineEmits(["handle-change-avatar"]);
const imageUrl = ref(null);

const props = defineProps(["isLoading"]);

const uploadAvatar = () => {
   const input = document.querySelector('input[name="ip_upload_avatar"]');
   input.click();
};

const selectedFile = ref(null);

const imageChange = (e) => {
   selectedFile.value = e.target.files[0];
   if (selectedFile.value != null) {
      imageUrl.value = URL.createObjectURL(selectedFile.value);
   }
};

const handleChangeAvatar = () => {
   emits("handle-change-avatar", selectedFile.value);
};

const closeModal = () => {
   imageUrl.value = null;
   selectedFile.value = null;
};

onMounted(() => {
   $("#avatarModal").on("hide.bs.modal", () => {
      imageUrl.value = null;
      selectedFile.value = null;
   });
});
</script>

<style scoped>
.avatar {
   width: 100%;
   height: 300px;
   margin-bottom: 20px;
}
</style>

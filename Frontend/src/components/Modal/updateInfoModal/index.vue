<template>
   <my-modal @clickTo="updateInfo" idModal="editAccount" :filledForm="filledForm">
      <template v-slot:title>Cập nhật thông tin</template>
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
      <div class="custom-input mb-4">
         <div class="wrap-info fw-bold mb-1">Tên tài khoản</div>
         <div class="wrap-input w-100">
            <input type="text" name="ip_displayname" v-model="model.fullname" />
         </div>
      </div>
      <div class="custom-input mb-4">
         <div class="wrap-info fw-bold mb-1">Ngày sinh</div>
         <div class="wrap-input w-100">
            <input type="text" name="ip_dob" v-model="model.birth" placeholder="xx-xx-xxxx" />
         </div>
      </div>
      <div class="custom-input mb-4">
         <div class="wrap-info fw-bold mb-1">Giới tính</div>
         <div class="wrap-input w-100">
            <select
               class="select_gender w-100 border-0"
               name="select_gender"
               v-model="model.gender"
            >
               <option value="1">Nam</option>
               <option value="0">Nữ</option>
            </select>
         </div>
      </div>
      <template v-slot:buttonName> Cập nhật</template>
   </my-modal>
</template>

<script setup>
import myModal from "@/components/Modal/Modal.vue";
import { computed, ref, watch, onMounted } from "vue";

const emits = defineEmits(["update-infor"]);
const props = defineProps(["user", "isLoading"]);

const formatBirth = computed(() => {
   const birth = new Date(props.user.birth);
   const day = birth.getDate().toString().padStart(2, "0");
   const month = (birth.getMonth() + 1).toString().padStart(2, "0");
   return `${day}-${month}-${birth.getFullYear()}`;
});

const model = ref({
   fullname: props.user.fullname,
   birth: formatBirth.value,
   gender: props.user.gender,
});

const filledForm = ref(false);
watch(model.value, () => {
   filledForm.value = true;
});

const updateInfo = () => {
   emits("update-infor", model.value);
};

onMounted(() => {
   $("#editAccount").on("hide.bs.modal", () => {
      filledForm.value = true;
      model.value = {
         fullname: props.user.fullname,
         birth: formatBirth.value,
         gender: props.user.gender,
      };
   });
});
</script>

<style></style>

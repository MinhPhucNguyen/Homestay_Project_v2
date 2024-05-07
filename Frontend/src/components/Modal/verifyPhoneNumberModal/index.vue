<template>
   <my-modal @clickTo="verifyPhoneNumber" idModal="verifyPhoneNumberModal">
      <template v-slot:title> <span> Xác minh số điện thoại </span></template>
      <div v-if="props.SMSOTPMessage" class="mt-4 text-center">
         <p>
            {{ props.SMSOTPMessage.message
            }}<strong class="text-black">{{ props.SMSOTPMessage.phone }}</strong>
         </p>
         <input
            type="text"
            class="otp-input w-100 border border-2 rounded p-3 fs-2 text-center"
            v-model="model.otp"
         />
         <div class="text-center fs-6 mt-3">
            <p>Bạn chưa nhận được mã?</p>
            <p v-if="timeLeft > 0">Yêu cầu mã mới trong vòng: {{ timeLeft }}s</p>
            <p class="mb-0" v-else>
               <a href="#" class="new-otp-btn" @click="resendOTP">Yêu cầu mã mới</a>
            </p>
         </div>
      </div>
      <div v-else-if="props.isLoading" class="w-100 d-flex justify-content-center mt-3 mb-4">
         <div class="spinner-grow text-success" role="status" style="width: 30px; height: 30px">
            <span class="visually-hidden">Loading...</span>
         </div>
      </div>
      <p v-else class="text-center mt-3 mb-0">
         {{ props.verificationMessage.message
         }}<strong class="text-black">{{ props.verificationMessage.phone }}</strong>
      </p>

      <template v-slot:buttonName>
         <span v-if="props.SMSOTPMessage">Xác thực</span>
         <span v-else> Tiếp tục </span>
      </template>
   </my-modal>
</template>

<script setup>
import myModal from "@/components/Modal/Modal.vue";
import { onMounted, ref } from "vue";

const props = defineProps(["isLoading", "verificationMessage", "SMSOTPMessage", "phone"]);
const emits = defineEmits(["send-otp", "verify-phone-number"]);

const model = ref({
   phone: props.phone,
   otp: null,
});
const timeLeft = ref(15);

const sendOTP = () => {
   emits("send-otp");
};

const resetTimeLeft = () => {
   timeLeft.value = 15;
};

const verifyPhoneNumber = () => {
   if (props.SMSOTPMessage && model.value.otp) {
      emits("verify-phone-number", model.value); //Xác nhận mã OTP sau khi nhập, nút tiếp tực
   } else {
      sendOTP();
   }
};

const resendOTP = () => {
   resetTimeLeft();
   sendOTP();
};

onMounted(() => {
   setInterval(() => {
      if (props.SMSOTPMessage && timeLeft.value > 0) {
         timeLeft.value--;
      }
   }, 1000);
   resetTimeLeft();
});

onMounted(() => {
   $("#verifyPhoneNumberModal").on("hide.bs.modal", () => {
      model.value = {
         phone: props.phone,
         otp: null,
      };
   });
   resetTimeLeft();
});
</script>

<style lang="scss" scoped>
.otp-input {
   height: 60px;
   outline: none;
}

.new-otp-btn {
   width: 100%;
   text-decoration: none;
   color: #1cc88a;
   padding: 14px 24px;
   font-weight: 500;
   border: 1px solid #1cc88a;
   border-radius: 6px;
   display: inline-block;

   &:hover {
      background-color: white;
   }
}
</style>

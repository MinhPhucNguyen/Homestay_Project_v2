<template>
   <ToastMessage :message="successMessage" />
   <updateInfoModal :user="user" @update-infor="updateInfor" :isLoading="isLoading" />
   <avatarUpload @handle-change-avatar="handleChangeAvatar" :isLoading="isLoading" />
   <updatePhoneNumberModal
      @update-phone-number="updateAndVerifyPhoneNumber"
      :user="user"
      :isLoading="isLoading"
      :errors="errors"
      :successMessage="successMessage"
      :isUpdatePhoneSuccess="isUpdatePhoneSuccess"
   />
   <verifyPhoneNumberModal
      @send-otp="sendOTP"
      @verify-phone-number="verifyPhoneNumber"
      :isLoading="isLoading"
      :verificationMessage="verificationMessage"
      :SMSOTPMessage="SMSOTPMessage"
      :phone="user.phone"
   />
   <updateEmailModal
      @handle-email="handleEmail"
      :user="user"
      :isLoading="isLoading"
      :errors="errors"
      :successMessage="successMessage"
      :isUpdateEmailSuccess="isUpdateEmailSuccess"
      :checkEmail="checkEmail"
   />

   <div class="content-item user-profile">
      <div class="content-title d-flex align-items-center justify-content-between">
         <div class="title-edit d-flex align-items-center">
            <h5 class="fs-3 mb-0">Thông tin tài khoản</h5>
            <div
               class="wrap-edit-btn edit-account-btn"
               data-bs-toggle="modal"
               data-bs-target="#editAccount"
            >
               <i class="fa-solid fa-pen"></i>
            </div>
         </div>
         <div class="total-trips d-flex">
            <i class="fa-solid fa-suitcase-rolling fs-3"></i>
            <p class="count mb-0">0</p>
            <span>Chuyến</span>
         </div>
      </div>
      <div class="content w-100 d-flex justify-content-between">
         <div class="avatar-wrap">
            <div class="avatar">
               <div class="avatar-container" data-bs-toggle="modal" data-bs-target="#avatarModal">
                  <img :src="user.avatar" alt="avatar" />
               </div>
            </div>
            <h6 class="user-fullname">{{ user.fullname }}</h6>
            <div class="note">
               Tham gia: <span>{{ dateJoin }}</span>
            </div>
            <div class="trip-class">
               <div>
                  <i class="fa-solid fa-medal fs-5"></i>
                  <p class="mb-0">0</p>
                  <span>điểm</span>
               </div>
            </div>
         </div>
         <div class="info-wrap h-100 d-flex flex-column">
            <div class="info-box">
               <div class="info-box-item d-flex justify-content-between align-items-center">
                  <p>Ngày sinh</p>
                  <p class="main">{{ formatBirth }}</p>
               </div>
               <div class="info-box-item d-flex justify-content-between align-items-center">
                  <p>Giới tính</p>
                  <p class="main">{{ user.gender === 1 ? "Nam" : "Nữ" }}</p>
               </div>
            </div>
            <div class="info-desc">
               <div class="info-desc-item">
                  <div class="title-item">
                     Số điện thoại
                     <div v-if="user.phone_is_verified" class="note success">
                        <i class="fa-solid fa-circle-check"></i>
                        <span> Đã xác thực</span>
                     </div>
                     <div v-else class="note warning verify-btn" @click="openModalVerify">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span> Xác minh</span>
                     </div>
                  </div>
                  <div class="name">
                     <span v-if="user.phone">{{ user.phone }}</span
                     ><span v-else>Thêm số điện thoại</span>
                     <div
                        class="wrap-edit-btn add-phone-number-btn"
                        data-bs-toggle="modal"
                        data-bs-target="#updatePhoneNumberModal"
                     >
                        <i class="fa-solid fa-pen"></i>
                     </div>
                  </div>
               </div>
               <div class="info-desc-item">
                  <div class="title-item">
                     Email
                     <div v-if="user.email_verified_at" class="note success">
                        <i class="fa-solid fa-circle-check"></i>
                        <span> Đã xác thực</span>
                     </div>
                     <div v-else class="note warning">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span>Xác minh</span>
                     </div>
                  </div>
                  <div class="name">
                     <span v-if="user.email">{{ user.email }}</span
                     ><span v-else>Thêm email</span>
                     <div
                        class="wrap-edit-btn update-email-btn"
                        data-bs-toggle="modal"
                        data-bs-target="#updateEmailModal"
                     >
                        <i class="fa-solid fa-pen"></i>
                     </div>
                  </div>
               </div>
               <div class="info-desc-item">
                  <div class="title-item">Facebook</div>
                  <div class="name">
                     Thêm liên kết
                     <div class="wrap-edit-btn">
                        <i class="fa-solid fa-link"></i>
                     </div>
                  </div>
               </div>
               <div class="info-desc-item">
                  <div class="title-item">Google</div>
                  <div class="name">
                     {{ user.username }}
                     <div class="wrap-edit-btn">
                        <i class="fa-solid fa-link"></i>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="content-item driver-license">
      <div class="content-title d-flex align-items-center justify-content-between">
         <div class="title-edit d-flex align-items-center">
            <h5 class="fs-3 mb-0">Giấy phép lái xe</h5>
            <div class="note success">
               <i class="fa-solid fa-circle-check"></i>
               Đã xác thực
            </div>
         </div>
         <div class="btn d-flex align-items-center">
            <span>Chỉnh sửa</span>
            <i class="fa-solid fa-pen"></i>
         </div>
      </div>
      <div class="content w-100 d-flex justify-content-between">
         <div class="info-license">
            <div class="lincense-title">Thông tin chung</div>
            <div class="custom-input">
               <div class="wrap-info fw-bold mb-1">Số GPLX</div>
               <div class="wrap-input w-100">
                  <input
                     type="text"
                     name="driver-license-number"
                     placeholder="Nhập số GPLX đã cấp"
                     disabled
                  />
               </div>
            </div>
            <div class="custom-input">
               <div class="wrap-info fw-bold mb-1">Họ và tên</div>
               <div class="wrap-input w-100">
                  <input
                     type="text"
                     name="driver-license-fullname"
                     placeholder="Nhập đầy đủ họ tên"
                     disabled
                  />
               </div>
            </div>
            <div class="custom-input">
               <div class="wrap-info fw-bold mb-1">Ngày sinh</div>
               <div class="wrap-input w-100">
                  <input type="text" name="driver-license-birth" :value="formatBirth" disabled />
               </div>
            </div>
         </div>
         <div class="info-license">
            <div class="lincense-title">Hình ảnh</div>
            <div class="license-upload w-100 h-100" @click="chooseLicenseUpload">
               <img v-if="licenseImageUrl" :src="licenseImageUrl" alt="" class="w-100 h-100" />
               <div v-else class="text-center">
                  <i class="fa-solid fa-cloud-arrow-up fs-2"></i>
                  <p>Chọn hình ảnh giấy phép</p>
                  <input
                     type="file"
                     class="d-none"
                     name="license-upload-input"
                     @change="handleLicenseImage"
                  />
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="content-item">
      <h5 class="fs-3">Giới thiệu bạn mới</h5>
      <p class="mb-0 d-flex align-items-center">
         Tìm hiểu chi tiết chương trình
         <i
            class="fa-solid fa-question border border-1 d-flex align-items-center justify-content-center"
            style="
               font-size: 10px;
               border-radius: 50%;
               margin-left: 5px;
               width: 20px;
               height: 20px;
               cursor: pointer;
            "
         ></i>
      </p>
   </div>
</template>

<script setup>
import updatePhoneNumberModal from "@/components/Modal/updatePhoneNumberModal/index.vue";
import verifyPhoneNumberModal from "@/components/Modal/verifyPhoneNumberModal/index.vue";
import updateEmailModal from "@/components/Modal/updateEmailModal/index.vue";
import updateInfoModal from "@/components/Modal/updateInfoModal/index.vue";
import avatarUpload from "@/components/Modal/avatarUpload/index.vue";
import ToastMessage from "@/components/Toast/index.vue";
import { computed, onMounted, ref } from "vue";
import { useStore } from "vuex";
import axios from "axios";

const store = useStore();
const licenseImageUrl = ref(null);
const successMessage = ref(null);
const isLoading = ref(false);
const errors = ref(null);
const user = ref({});

/**
 * TODO: FETCH USER WHEN AUTHENTICATED
 */
// user.value = store.getters["auth/getUser"];
user.value = store.getters["users/getUserById"];

const fetchUserById = async () => {
   return await store.dispatch("users/fetchUserById", user.value.id).then((response) => {
      user.value = response.data.user;
   });
};

const formatBirth = computed(() => {
   const birth = new Date(user.value.birth);
   const day = birth.getDate().toString().padStart(2, "0");
   const month = (birth.getMonth() + 1).toString().padStart(2, "0");
   return `${day}-${month}-${birth.getFullYear()}`;
});

const dateJoin = computed(() => {
   const date = new Date(user.value.created_at);
   const day = date.getDate().toString().padStart(2, "0");
   const month = (date.getMonth() + 1).toString().padStart(2, "0");
   const year = date.getFullYear();
   return `${day}/${month}/${year}`;
});

const chooseLicenseUpload = () => {
   const input = document.querySelector("input[name='license-upload-input']");
   input.click();
};

const handleLicenseImage = (e) => {
   const selectedFile = e.target.files[0];
   if (selectedFile) {
      licenseImageUrl.value = URL.createObjectURL(selectedFile);
   }
};

/**
 * TODO: UPLOAD AVATAR
 * @param {*} file
 */
const id = user.value.id;
const handleChangeAvatar = async (file) => {
   const formData = new FormData();
   formData.append("profile_avatar", file);
   isLoading.value = true;
   store.dispatch("users/updateAvatar", { id, formData }).then((response) => {
      successMessage.value = "Thay đổi thành công";
      fetchUserById().then(() => {
         isLoading.value = false;
         $("#avatarModal").modal("hide");
         $(".toast").toast("show");
      });
   });
};

/**
 * TODO: UPDATE INFO
 */
const updateInfor = async (model) => {
   isLoading.value = true;
   await store
      .dispatch("users/updateInfor", { id, model })
      .then((response) => {
         successMessage.value = response.data.message;
         fetchUserById().then(() => {
            isLoading.value = false;
            $("#editAccount").modal("hide");
            $(".toast").toast("show");
         });
      })
      .catch((e) => {
         console.log(e);
         if (e.response) {
            isLoading.value = false;
            errors.value = e.response.data.errors;
         }
      });
};

/**
 * TODO: UPDATE PHONE NUMBER
 */
const isUpdatePhoneSuccess = ref(false);

const updateAndVerifyPhoneNumber = (model) => {
   if (model.isVerify === true) {
      openVerifyPhoneNumberModal(model.phone);
   } else {
      updatePhoneNumber(model);
   }
};

const verificationMessage = ref("");
const openVerifyPhoneNumberModal = async (phone) => {
   $("#updatePhoneNumberModal").modal("hide");
   $("#verifyPhoneNumberModal").modal("show");

   await axios
      .post(`v2/users/verification-now`, { phone })
      .then((response) => {
         verificationMessage.value = {
            message: response.data.message,
            phone: response.data.phone,
         };
      })
      .catch((e) => {
         alert(e.response.data.errors);
      });
};

const SMSOTPMessage = ref("");
const sendOTP = async () => {
   isLoading.value = true;
   await axios
      .post(`v2/users/${id}/send-phone-verification`)
      .then((response) => {
         isLoading.value = false;
         SMSOTPMessage.value = {
            message: response.data.message,
            phone: response.data.phone,
         };
      })
      .catch((e) => {
         isLoading.value = false;
         console.log(e.response);
      });
};

const verifyPhoneNumber = async (model) => {
   await axios
      .get("/phone-verification", {
         params: {
            phone: model.phone,
            otp: model.otp,
         },
      })
      .then((response) => {
         successMessage.value = response.data.message;
         fetchUserById();
         $(".toast").toast("show");
         $("#verifyPhoneNumberModal").modal("hide");
      })
      .catch((e) => {
         alert(e.response.data.errors);
      });
};

const updatePhoneNumber = async (model) => {
   isLoading.value = true;
   await axios
      .patch(`v2/users/${id}/update-phone`, model)
      .then((response) => {
         successMessage.value = response.data.message;
         fetchUserById().then(() => {
            isLoading.value = false;
            isUpdatePhoneSuccess.value = true;
         });
      })
      .catch((e) => {
         if (e.response) {
            console.log(e);
            errors.value = "*Không hợp lệ mời nhập lại";
            $("#updatePhoneNumberModal").modal("show");
            isLoading.value = false;
         }
      });
};

/**
 * TODO:UPDATE AND EMAIL VERIFICATION
 */
const isUpdateEmailSuccess = ref(false);

const handleEmail = (model) => {
   if (model === true) {
      verificationEmail();
   } else {
      updateEmail(model);
   }
};

const updateEmail = async (model) => {
   isLoading.value = true;
   await axios
      .patch(`v2/users/${id}/update-email`, model)
      .then((response) => {
         successMessage.value = response.data.message;
         fetchUserById().then(() => {
            isLoading.value = false;
            isUpdateEmailSuccess.value = true;
         });
      })
      .catch((e) => {
         if (e.response) {
            if (e.response.data.errors.email[0] === "*Please enter a valid email") {
               errors.value = "*Vui lòng nhập email hợp lệ";
            } else if (e.response.data.errors.email[0] === "*Email already exists") {
               errors.value = "*Email đã tồn tại";
            }
            $("#updateEmailModal").modal("show");
            isLoading.value = false;
         }
      });
};

const checkEmail = ref("");
const verificationEmail = async () => {
   checkEmail.value = "Vui lòng kiểm tra email của bạn.";
   isLoading.value = true;
   await axios
      .post(`v2/users/${id}/send-email-verification`)
      .then((response) => {
         console.log(response.data);
      })
      .catch((e) => {
         console.log(e);
      });
};

onMounted(() => {
   if (store.state["users"].verifiedMessage !== "") {
      successMessage.value = store.state["users"].verifiedMessage;
      setTimeout(() => {
         $(".toast").toast("show");
      }, 2000);
      fetchUserById();
   }

   $(".toast").on("hide.bs.toast", () => {
      store.commit("users/SET_VERIFIED_MESSAGE", "");
   });
});

onMounted(() => {
   $("#updateEmailModal").on("hide.bs.modal", () => {
      isUpdateEmailSuccess.value = false;
      isLoading.value = false;
      checkEmail.value = "";
      errors.value = null;
   });

   $("#updatePhoneNumberModal").on("hide.bs.modal", () => {
      isUpdatePhoneSuccess.value = false;
      successMessage.value = "";
      verificationMessage.value = "";
      SMSOTPMessage.value = "";
      isLoading.value = false;
      errors.value = null;
   });
});
</script>

<style scoped>
@import url("./AccountContent.scss");
</style>

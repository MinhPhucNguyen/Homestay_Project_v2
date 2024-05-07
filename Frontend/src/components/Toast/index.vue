<template>
   <div
      class="toast align-items-center shadow"
      role="toast"
      aria-live="assertive"
      aria-atomic="true"
      :style="{ backgroundColor: bgColor }"
   >
      <div class="toast-content d-flex p-0">
         <div class="d-flex align-items-center mr-3 fs-5">
            <i class="fa-solid fa-circle-check"></i>
         </div>
         <div class="toast-body p-0 fw-bold mw-50">
            <p class="m-0">{{ message }}</p>
         </div>
         <div class="close-btn">
            <button
               type="button"
               class="btn-close btn-close-white me-2 m-auto"
               data-bs-dismiss="toast"
               aria-label="Close"
            ></button>
         </div>
      </div>
   </div>
</template>

<script>
import { computed } from "vue";

export default {
   name: "ToastMessage",
   props: {
      message: {
         type: String,
         default: "",
      },
      toastType: {
         type: String,
         default: "success",
      },
   },
   setup(props) {
      const bgColor = computed(() => {
         if (props.toastType == "danger") {
            return "#e74a3be0";
         } else if (props.toastType == "success") {
            return "#1cc889e0";
         }
      });

      return {
         bgColor,
      };
   },
};
</script>

<style scoped>
.toast {
   position: fixed;
   right: 30px;
   top: 100px;
   padding: 18px 30px 18px 15px;
   font-size: 16px;
   border-radius: 8px;
   color: #fff;
   animation: slideInLeft ease 0.3s;
   width: 700px;
   z-index: 9999;
}

.toast-body {
   max-width: 280px;
}

.close-btn {
   position: absolute;
   top: 20px;
   right: 6px;
   transform: translateY(-50%);
   cursor: pointer;
   outline: none;
}

.hide-toast {
   animation: slideOutLeft ease 0.3s;
}

@keyframes slideInLeft {
   from {
      transform: translateX(calc(100% + 30px));
   }
   to {
      transform: translateX(0);
   }
}

@keyframes slideOutLeft {
   from {
      transform: translateX(0);
   }
   to {
      transform: translateX(calc(100% + 30px));
   }
}
</style>

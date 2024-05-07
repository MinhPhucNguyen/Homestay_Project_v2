<template>
   <ToastMessage :message="successMessage" />

   <div id="email" class="section active">
      <div class="view-right-item rounded-3 border d-flex justify-content-between">
         <div class="w-100">
            <div class="w-50 mx-auto mt-4">
               <form @submit.prevent="sendEmail" class="emailFrom">
                  <div class="form-group mb-4">
                     <label class="fw-bold mb-0" for="">From</label>
                     <input
                        type="text"
                        name="emailFrom"
                        placeholder="Enter Email"
                        class="form-control"
                        v-model="model.emailFrom"
                     />
                     <small class="text-danger" v-if="errors && errors.emailFrom">
                        {{ errors.emailFrom[0] }}
                     </small>
                  </div>

                  <div class="form-group mb-4">
                     <label class="fw-bold mb-0" for="">Name</label>
                     <input
                        type="text"
                        name="name"
                        placeholder="Enter Name"
                        class="form-control"
                        v-model="model.name"
                     />
                  </div>

                  <div class="form-group mb-4">
                     <label class="fw-bold mb-0" for="">To</label>
                     <input
                        type="text"
                        name="emailTo"
                        placeholder="Enter Email"
                        class="form-control"
                        v-model="model.emailTo"
                     />
                     <small class="text-danger" v-if="errors && errors.emailTo">
                        {{ errors.emailTo[0] }}
                     </small>
                  </div>

                  <div class="form-group mb-4">
                     <label class="fw-bold mb-0" for="">Subject</label>
                     <input
                        type="text"
                        name="subject"
                        placeholder="Enter Subject"
                        class="form-control"
                        v-model="model.subject"
                     />
                  </div>

                  <div class="form-group">
                     <label class="fw-bold mb-0" for="">Message</label>
                     <textarea
                        name="message"
                        placeholder="Enter Message"
                        class="form-control"
                        cols="1"
                        rows="8"
                        v-model="model.message"
                     ></textarea>
                  </div>
                  <div class="float-end">
                     <button
                        type="submit"
                        class="btn btn-success fw-bold pl-4 pr-4 send-btn"
                        :disabled="isSending"
                     >
                        <div v-if="isSending">
                           <span
                              class="spinner-border spinner-border-sm"
                              role="status"
                              aria-hidden="true"
                           ></span>
                           <span class="ml-1">Sending...</span>
                        </div>
                        <div v-else>
                           <i class="fa-regular fa-paper-plane"></i>
                           <span class="ml-1">Send</span>
                        </div>
                     </button>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</template>

<script>
import { computed, ref } from "vue";
import { useStore } from "vuex";
import axios from "axios";
import ToastMessage from "@/components/Toast/index.vue";

export default {
   name: "SendEmail",
   components: {
      ToastMessage,
   },
   setup() {
      const model = ref({
         emailFrom: "johnnynguyen1619@gmail.com",
         name: "",
         emailTo: "",
         subject: "",
         message: "",
      });
      const errors = ref(null);
      const successMessage = ref(null);
      const store = useStore();
      const isSending = ref(false);

      const user = computed(() => store.getters["users/getUserById"]);
      model.value.emailTo = user.value.email;

      const sendEmail = async () => {
         isSending.value = true;
         await axios
            .post("v2/admin/send-email", model.value)
            .then((response) => {
               $(".toast").toast("show");
               if (response.data.message) {
                  successMessage.value = response.data.message;
                  isSending.value = false;
               }
            })
            .catch((e) => {
               if (e.response) {
                  isSending.value = false;
                  errors.value = e.response.data.errors;
               }
            });
      };

      return { model, sendEmail, errors, isSending, successMessage };
   },
};
</script>

<style></style>

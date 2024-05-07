<template>
   <ToastMessage :message="successMessage" />

   <my-modal @clickTo="handleDeleteFeature" idModal="deleteConfirmModal" bgColor="danger">
      <template v-slot:title>Delete brand</template>
      <h6 class="text-dark text-center fs-5 mt-4">
         Are you sure, you want to delete this feature?
      </h6>
      <template v-slot:buttonName>
         <div
            class="spinner-border"
            role="status"
            style="width: 24px; height: 24px; margin-right: 10px"
            v-if="isLoading"
         >
            <span class="visually-hidden">Loading...</span>
         </div>
         Delete
      </template>
   </my-modal>

   <div class="col-md-12 p-0">
      <div class="card">
         <div class="card-header bg-transparent d-flex align-items-center border-0">
            <div class="d-inline-block fw-bold text-dark fs-4 flex-grow-1">Features List</div>
            <div>
               <button class="btn btn-success fw-bold float-right ml-3" @click="addFeature">
                  <i class="fa-solid fa-plus"></i>
                  Add New Feature
               </button>
            </div>
         </div>
         <div class="card-body mt-0">
            <table class="table table-bordered table-striped">
               <thead>
                  <tr class="text-dark">
                     <th class="text-center">ID</th>
                     <th class="text-center">Name</th>
                     <th class="text-center">Logo</th>
                     <th class="text-center">Action</th>
                  </tr>
               </thead>
               <tbody>
                  <tr v-for="feature in featuresList" :key="feature.id">
                     <td class="text-center">{{ feature.id }}</td>
                     <td class="text-center">{{ feature.name }}</td>
                     <td class="text-center">{{ feature.logo }}</td>
                     <td class="text-center">
                        <div class="dropdown">
                           <button
                              class="btn btn-success dropdown-toggle"
                              type="button"
                              data-bs-toggle="dropdown"
                              aria-expanded="false"
                           >
                              Action
                           </button>
                           <ul class="dropdown-menu">
                              <li>
                                 <button
                                    type="button"
                                    class="dropdown-item mb-3 fs-6 text-success bg-white"
                                    @click="editFeature(feature)"
                                 >
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    <span class="ml-2"> Edit</span>
                                 </button>
                              </li>
                              <li>
                                 <button
                                    type="button"
                                    class="dropdown-item fs-6 text-danger bg-white"
                                    @click="deleteFeature(feature)"
                                 >
                                    <i class="fa-solid fa-trash"></i>
                                    <span class="ml-2">Delete</span>
                                 </button>
                              </li>
                           </ul>
                        </div>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>

      <div
         class="modal fade"
         id="featureFormModal"
         tabindex="-1"
         aria-labelledby="createFeatureModalLabel"
         aria-hidden="true"
      >
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <h1 class="modal-title fs-5" id="createFeatureModalLabel" v-if="isEditing">
                     Edit Feature
                  </h1>
                  <h1 class="modal-title fs-5" id="createFeatureModalLabel" v-else>Add Feature</h1>
                  <button
                     type="button"
                     class="btn-close"
                     data-bs-dismiss="modal"
                     aria-label="Close"
                  ></button>
               </div>
               <div class="modal-body">
                  <form @submit.prevent="featureSubmit">
                     <div class="form-group">
                        <label for="" class="text-dark">Name</label>
                        <input type="text" class="form-control" v-model="model.name" />
                        <small class="text-danger" v-if="errors.name">{{ errors.name[0] }}</small>
                     </div>
                     <div class="form-group">
                        <label for="" class="text-dark">Logo</label>
                        <input type="text" class="form-control" v-model="model.logo" />
                     </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                           Close
                        </button>
                        <button
                           type="submit"
                           class="btn btn-success pr-4 pl-4 fw-bold"
                           :disabled="isLoading"
                           v-if="isEditing"
                        >
                           <div
                              class="spinner-border"
                              role="status"
                              style="width: 20px; height: 20px; margin-right: 10px"
                              v-if="isLoading"
                           >
                              <span class="visually-hidden">Loading...</span>
                           </div>
                           Save chanage
                        </button>
                        <button
                           type="submit"
                           class="btn btn-success pr-4 pl-4 fw-bold"
                           :disabled="isLoading"
                           v-else
                        >
                     
                           Create
                        </button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</template>

<script setup>
import { onBeforeMount, ref } from "vue";
import { useStore } from "vuex";
import ToastMessage from "@/components/Toast/index.vue";
import axios from "axios";
import MyModal from "@/components/Modal/Modal.vue";

const store = useStore();
const featuresList = ref([]);
const model = ref({
   name: "",
   logo: "",
});
const isEditing = ref(false);
const errors = ref({});
const successMessage = ref(null);
const isLoading = ref(false);

const getFeaturesList = async () => {
   return await store.dispatch("cars/fetchFeatures").then(() => {
      featuresList.value = store.getters["cars/getFeaturesList"];
   });
};

onBeforeMount(() => {
   getFeaturesList();
});

const resetForm = () => {
   model.value = {
      name: "",
      logo: "",
   };
};

const featureSubmit = () => {
   if (isEditing.value) {
      updateFeature();
   } else {
      addNewFeatures();
   }
};

/**
 * TODO: ADD NEW FEATURE
 */
const addFeature = () => {
   isEditing.value = false;
   resetForm();
   $("#featureFormModal").modal("show");
};

const addNewFeatures = () => {
   isLoading.value = true;
   axios
      .post("v2/admin/features/create", model.value)
      .then((response) => {
         successMessage.value = response.data.message;
         getFeaturesList().then(() => {
            resetForm();
            isLoading.value = false;
            $("#featureFormModal").modal("hide");
            $(".toast").toast("show");
         });
      })
      .catch((e) => {
         if (e.response) {
            isLoading.value = false;
            $("#featureFormModal").modal("show");
            errors.value = e.response.data.errors;
         }
      });
};

/**
 * TODO: EDIT FEATURE
 */
const editFeature = (feature) => {
   isEditing.value = true;
   $("#featureFormModal").modal("show");
   model.value = { ...feature };
};

const updateFeature = () => {
   isLoading.value = true;
   axios.put(`v2/admin/features/${model.value.id}/update`, model.value).then((response) => {
      successMessage.value = response.data.message;
      getFeaturesList()
         .then(() => {
            isLoading.value = false;
            $(".toast").toast("show");
            $("#featureFormModal").modal("hide");
            resetForm();
         })
         .catch((e) => {
            if (e.response) {
               isLoading.value = false;
               $("#featureFormModal").modal("show");
               errors.value = e.response.data.errors;
            }
         });
   });
};

/**
 * TODO: DELETE FEATURE
 */
const deleteFeature = (feature) => {
   model.value = { ...feature };
   $("#deleteConfirmModal").modal("show");
};

const handleDeleteFeature = () => {
   isLoading.value = true;
   axios.delete(`v2/admin/features/${model.value.id}/delete`).then((response) => {
      successMessage.value = response.data.message;
      getFeaturesList()
         .then(() => {
            isLoading.value = false;
            successMessage.value = response.data.message;
            $("#deleteConfirmModal").modal("hide");
            $(".toast").toast("show");
         })
         .catch((e) => {
            if (e.response) {
               isLoading.value = false;
               $("#featureFormModal").modal("show");
               errors.value = e.response.data.errors;
            }
         });
   });
};
</script>

<style></style>

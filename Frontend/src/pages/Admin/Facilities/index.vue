<template>
  <ToastMessage :message="successMessage" />

  <my-modal
    @clickTo="handleDeleteFacility"
    idModal="deleteConfirmModal"
    bgColor="danger"
  >
    <template v-slot:title>Xóa tiện nghi</template>
    <h6 class="text-dark text-center fs-5 mt-4">
      Bạn có chắc chắn muốn xóa tiện nghi này không?
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
      Xóa
    </template>
  </my-modal>

  <div class="col-md-12 p-0">
    <div class="card">
      <div
        class="card-header bg-transparent d-flex align-items-center border-0"
      >
        <div class="d-inline-block fw-bold text-dark fs-4 flex-grow-1">
          Danh sách tiện nghi
        </div>
        <div>
          <button
            class="btn btn-success fw-bold float-right ml-3"
            @click="addFacilities"
          >
            <i class="fa-solid fa-plus"></i>
            Thêm mới tiện nghi
          </button>
        </div>
      </div>
      <div class="card-body mt-0">
        <div class="mb-3 d-flex align-items-center justify-content-between">
          <div class="w-25 mt-3 d-flex align-items-center">
            <i class="fa-solid fa-magnifying-glass fs-5 mr-2"></i>
            <input
              type="text"
              name="search"
              class="form-control small search-input border border-dark-subtletext-dark"
              placeholder="Tìm kiếm ..."
              v-model="searchInput"
            />
          </div>
        </div>
        <table class="table table-bordered table-striped">
          <thead>
            <tr class="text-dark">
              <th class="text-center">ID</th>
              <th class="text-center">Tên tiện nghi</th>
              <th class="text-center">Icon</th>
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="facility in facilitiesList" :key="facility.facility_id">
              <td class="text-center">{{ facility.facility_id }}</td>
              <td class="text-center">{{ facility.facility_name }}</td>
              <td class="text-center">
                <img
                  v-if="facility.facility_icon"
                  :src="'data:image/svg+xml;utf8,' + facility.facility_icon"
                  width="30"
                  height="30"
                />
                <p v-else>Không có icon</p>
              </td>
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
                        @click="editFacility(facility)"
                      >
                        <i class="fa-solid fa-pen-to-square"></i>
                        <span class="ml-2"> Sửa</span>
                      </button>
                    </li>
                    <li>
                      <button
                        type="button"
                        class="dropdown-item fs-6 text-danger bg-white"
                        @click="deleteFacility(facility)"
                      >
                        <i class="fa-solid fa-trash"></i>
                        <span class="ml-2">Xóa</span>
                      </button>
                    </li>
                  </ul>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="pagination">
          <Pagination
            :pagination="pagination"
            @pagination-page="getFacilitiesList"
          />
        </div>
      </div>
    </div>

    <div
      class="modal fade"
      id="facilityFormModal"
      tabindex="-1"
      aria-labelledby="createFacilityModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1
              class="modal-title fs-5"
              id="createFeatureModalLabel"
              v-if="isEditing"
            >
              Sửa tiện nghi
            </h1>
            <h1 class="modal-title fs-5" id="createFeatureModalLabel" v-else>
              Thêm tiện nghi
            </h1>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="facilitySubmit">
              <div class="form-group">
                <label for="" class="text-dark">Tên tiện nghi</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="model.facility_name"
                />
                <small class="text-danger" v-if="errors.facility_name">{{
                  errors.facility_name[0]
                }}</small>
              </div>
              <div class="form-group">
                <label for="iconType" class="text-dark">Loại Icon</label>
                <select class="form-control" v-model="iconType">
                  <option value="upload">Upload ảnh</option>
                  <option value="svg">Nhập SVG</option>
                </select>
              </div>
              <div class="form-group" v-if="iconType === 'upload'">
                <label for="facility_icon" class="text-dark">Upload Icon</label>
                <input
                  type="file"
                  class="form-control"
                  @change="onFileChange"
                />
              </div>
              <div class="form-group" v-if="iconType === 'svg'">
                <label for="facility_icon" class="text-dark">Nhập SVG</label>
                <textarea
                  class="form-control"
                  v-model="model.facility_icon"
                  rows="4"
                ></textarea>
              </div>
              <div class="modal-footer">
                <button
                  type="button"
                  class="btn btn-secondary"
                  data-bs-dismiss="modal"
                >
                  Đóng
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
                  Lưu thay đổi
                </button>
                <button
                  type="submit"
                  class="btn btn-success pr-4 pl-4 fw-bold"
                  :disabled="isLoading"
                  v-else
                >
                  Tạo
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
import {onBeforeMount, onMounted, ref, watch} from "vue";
import { useStore } from "vuex";
import ToastMessage from "@/components/Toast/index.vue";
import axios from "axios";
import MyModal from "@/components/Modal/Modal.vue";
import Pagination from "@/components/Pagination/index.vue";
import { debounce } from "@/utils/debounce.js";

const store = useStore();
const facilitiesList = ref([]);
const model = ref({
  facility_name: "",
  facility_icon: "",
});
const iconType = ref("svg");
const isEditing = ref(false);
const errors = ref({});
const successMessage = ref(null);
const isLoading = ref(false);
const searchInput = ref("");
const pagination = ref({});

const getFacilitiesList = (page = 1) => {
  store
    .dispatch("homestays/fetchFacilities", {
      page,
      searchInput,
    })
    .then((res) => {
      facilitiesList.value = store.getters["homestays/getFacilitiesList"];
      pagination.value = res.pagination;
    });
};

const debouncedGetFacilitiessList = debounce(getFacilitiesList, 300);

watch(searchInput, () => {
  debouncedGetFacilitiessList();
});

onBeforeMount(() => {
  getFacilitiesList();
});

const onFileChange = (event) => {
  const file = event.target.files[0];
  if (file) {
    model.value.facility_icon = file;
  }
};

const resetForm = () => {
  model.value = {
    facility_name: "",
    facility_icon: "",
  };
  iconType.value = "svg";
  errors.value = {};
};

const facilitySubmit = () => {
  if (isEditing.value) {
    updateFacility();
  } else {
    addNewFacility();
  }
};

/**
 * TODO: ADD NEW FACILITY
 */
const addFacilities = () => {
  isEditing.value = false;
  resetForm();
  $("#facilityFormModal").modal("show");
};

const addNewFacility = () => {
  isLoading.value = true;
  axios
    .post("v2/facilities/create", model.value)
    .then((response) => {
      successMessage.value = response.data.message;
      getFacilitiesList();
      resetForm();
      isLoading.value = false;
      $("#facilityFormModal").modal("hide");
      $(".toast").toast("show");
    })
    .catch((e) => {
      if (e.response) {
        isLoading.value = false;
        $("#facilityFormModal").modal("show");
        errors.value = e.response.data.errors;
      }
    });
};

/**
 * TODO: EDIT FACILITY
 */
const editFacility = (facility) => {
  isEditing.value = true;
  $("#facilityFormModal").modal("show");
  model.value = { ...facility };
};

const updateFacility = () => {
  isLoading.value = true;
  axios
    .post(`v2/facilities/${model.value.facility_id}/edit`, model.value, {
      params: { _method: "put" },
    })
    .then((response) => {
      successMessage.value = response.data.message;
      getFacilitiesList();
      isLoading.value = false;
      successMessage.value = response.data.message;
      $(".toast").toast("show");
      $("#facilityFormModal").modal("hide");
      resetForm();
    })
    .catch((e) => {
      if (e.response) {
        isLoading.value = false;
        $("#facilityFormModal").modal("show");
        errors.value = e.response.data.errors;
      }
    });
};

/**
 * TODO: DELETE FEATURE
 */
const deleteFacility = (feature) => {
  model.value = { ...feature };
  $("#deleteConfirmModal").modal("show");
  console.log(model.value);
};

const handleDeleteFacility = () => {
  isLoading.value = true;
  axios
    .delete(`v2/facilities/${model.value.facility_id}/delete`)
    .then((response) => {
      successMessage.value = response.data.message;
      getFacilitiesList();
      isLoading.value = false;
      successMessage.value = response.data.message;
      $("#deleteConfirmModal").modal("hide");
      $(".toast").toast("show");
    })
    .catch((e) => {
      if (e.response) {
        isLoading.value = false;
        $("#facilityFormModal").modal("show");
        errors.value = e.response.data.errors;
      }
    });
};

onMounted(() => {
  $("#facilityFormModal").on("hide.bs.modal", () => {
    errors.value = {};
    resetForm();
  });
});

</script>

<style></style>

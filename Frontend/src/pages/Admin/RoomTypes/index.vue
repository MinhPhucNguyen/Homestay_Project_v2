<template>
  <ToastMessage :message="successMessage"/>

  <my-modal
      @clickTo="handleDeleteRoomType"
      idModal="deleteConfirmModal"
      bgColor="danger"
  >
    <template v-slot:title>Xóa loại phòng</template>
    <h6 class="text-dark text-center fs-5 mt-4">
      Bạn có chắc chắn muốn xóa loại phòng này?
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

  <div class="col-md-12">
    <div class="card">
      <div class="card-header bg-transparent d-flex align-items-center">
        <div class="d-inline-block fw-bold text-dark fs-4 flex-grow-1">
          Loại phòng
        </div>
        <div>
          <button
              class="btn btn-success fw-bold float-right ml-3"
              @click="addRoomType"
          >
            <i class="fa-solid fa-plus"></i>
            Thêm loại phòng
          </button>
        </div>
      </div>
      <div class="card-body m-0">
        <table class="table table-bordered table-striped">
          <thead>
          <tr class="text-dark">
            <th class="text-center">Mã loại phòng</th>
            <th class="text-center">Tên loại phòng</th>
            <th class="text-center">Tên homestay</th>
            <th class="text-center">Mô tả</th>
            <th class="text-center">Số giường</th>
            <th class="text-center">Giá ngày</th>
            <th class="text-center">Giá giờ</th>
            <th class="text-center">Action</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="roomType in roomTypes" :key="roomType.room_type_id">
            <td class="text-center">{{ roomType.room_type_id }}</td>
            <td class="text-center">{{ roomType.name }}</td>
            <td class="text-center">
              <div v-if="roomType.room_prices.length">
                <div
                    v-for="roomPrice in roomType.room_prices"
                    :key="roomPrice.id"
                >
                  {{ roomPrice.homestay_name }}
                </div>
              </div>
              <div v-else>Chưa có homestay</div>
            </td>
            <td class="text-center rt-description">
              <div
                  v-html="roomType.description"
                  v-if="roomType.description"
              ></div>
              <div v-else>Chưa có mô tả</div>
            </td>
            <td class="text-center">{{ roomType.number_of_beds }}</td>
            <td class="text-center">
              <div v-if="roomType.room_prices.length">
                <div
                    v-for="roomPrice in roomType.room_prices"
                    :key="roomPrice.id"
                >
                  {{ formatCurrency(roomPrice.price_per_day) }}
                </div>
              </div>
              <div v-else>{{ formatCurrency(0) }}</div>
            </td>
            <td class="text-center">
              <div v-if="roomType.room_prices.length">
                <div
                    v-for="roomPrice in roomType.room_prices"
                    :key="roomPrice.id"
                >
                  {{ formatCurrency(roomPrice.price_per_hour) }}
                </div>
              </div>
              <div v-else>{{ formatCurrency(0) }}</div>
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
                        @click="editRoomType(roomType)"
                    >
                      <i class="fa-solid fa-pen-to-square"></i>
                      <span class="ml-2">Sửa</span>
                    </button>
                  </li>
                  <li>
                    <button
                        type="button"
                        class="dropdown-item fs-6 text-danger bg-white"
                        @click="deleteRoomType(roomType)"
                    >
                      <i class="fa-solid fa-trash"></i>
                      <span class="ml-2">Xóa</span>
                    </button>
                  </li>
                </ul>
              </div>
            </td>
          </tr>
          <tr v-if="roomTypes.length === 0">
            <td colspan="8" class="text-center">
              <stateLoading/>
            </td>
          </tr>
          </tbody>
        </table>
        <div class="pagination">
          <Pagination
              :pagination="pagination"
              @pagination-page="getRoomTypesList"
          />
        </div>
      </div>
    </div>

    <div
        class="modal fade"
        id="roomTypeFormModal"
        tabindex="-1"
        aria-labelledby="roomTypeFormModalLabel"
        aria-hidden="true"
    >
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h1
                class="modal-title fs-5"
                id="roomTypeFormModalLabel"
                v-if="isEditing"
            >
              Sửa loại phòng
            </h1>
            <h1 class="modal-title fs-5" id="roomTypeFormModalLabel" v-else>
              Thêm loại phòng
            </h1>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="roomTypeSubmit">
              <div class="form-group">
                <label for="" class="text-dark fw-bold">Tên loại phòng</label>
                <input
                    type="text"
                    class="form-control"
                    name="name"
                    v-model="model.name"
                />
                <small class="text-danger" v-if="errors">{{
                      errors.name[0]
                  }}</small>
              </div>
              <div class="form-group">
                <label for="" class="text-dark fw-bold">Số giường</label>
                <input
                    type="text"
                    class="form-control"
                    name="number_of_beds"
                    v-model="model.number_of_beds"
                />
                <small
                    class="text-danger"
                    v-if="errors && errors.number_of_beds"
                >{{ errors.number_of_beds[0] }}</small
                >
              </div>
              <div class="form-group">
                <label for="" class="text-dark fw-bold">Giá ngày (VND)</label>
                <input
                    type="text"
                    class="form-control"
                    name="price_per_day"
                    v-model="model.price_per_day"
                />
                <small
                    class="text-danger"
                    v-if="errors && errors.price_per_day"
                >{{ errors.price_per_day[0] }}</small
                >
              </div>
              <div class="form-group">
                <label for="" class="text-dark fw-bold">Giá giờ (VND)</label>
                <input
                    type="text"
                    class="form-control"
                    name="price_per_hour"
                    v-model="model.price_per_hour"
                />
                <small
                    class="text-danger"
                    v-if="errors && errors.price_per_hour"
                >{{ errors.price_per_hour[0] }}</small
                >
              </div>
              <div class="form-group">
                <label for="" class="text-dark fw-bold">Homestay</label>
                <multiselect
                    v-model="selectedValue"
                    :options="selectOptions"
                    placeholder="Vui lòng chọn"
                    label="homestay_name"
                    track-by="homestay_id"
                >
                  <template #noResult>
                    <span
                    >Không tìm thấy homestay nào, vui lòng nhập lại.</span
                    >
                  </template>
                </multiselect>
                <small class="text-danger" v-if="errors && errors.homestay_id">{{
                    errors.homestay_id[0]
                  }}</small>
              </div>
              <div class="form-group">
                <label for="" class="text-dark fw-bold">Mô tả</label>
                <div>
                  <ckeditorComponent
                      v-model="model.description"
                  ></ckeditorComponent>
                </div>
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
                    class="btn btn-success pr-4 pl-4 d-flex align-items-center"
                    v-if="isEditing"
                >
                  <div
                      class="spinner-border"
                      role="status"
                      style="width: 20px; height: 20px; margin-right: 10px"
                      v-if="isLoading && isEditing"
                  >
                    <span class="visually-hidden">Loading...</span>
                  </div>
                  Lưu thay đổi
                </button>
                <button
                    type="submit"
                    class="btn btn-success pr-4 pl-4 d-flex align-items-center"
                    v-else
                >
                  <div
                      class="spinner-border"
                      role="status"
                      style="width: 20px; height: 20px; margin-right: 10px"
                      v-if="isLoading"
                  >
                    <span class="visually-hidden">Loading...</span>
                  </div>
                  Thêm
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
import ckeditorComponent from "@/components/Editor/index.vue";
import {onBeforeMount, onMounted, ref, watch} from "vue";
import Multiselect from "vue-multiselect";
import axios from "axios";
import {useStore} from "vuex";
import MyModal from "@/components/Modal/Modal.vue";
import ToastMessage from "@/components/Toast/index.vue";
import stateLoading from "@/components/Loading/Loading.vue";
import Pagination from "@/components/Pagination/index.vue";
import {formatCurrency} from "@/utils/formatCurrency";

const store = useStore();
const roomTypes = ref([]);
const model = ref({
  name: "",
  description: "",
  number_of_beds: 0,
  homestay_id: 0,
  price_per_day: 0,
  price_per_hour: 0,
});
const errors = ref(null);
const isEditing = ref(false);
const successMessage = ref(null);
const isLoading = ref(false);
const pagination = ref({});

const selectedValue = ref(null);
const selectOptions = ref([]);

watch(selectedValue, (value) => {
  if (value) {
    model.value.homestay_id = value.homestay_id;
  }
});

const resetForm = () => {
  model.value = {
    name: "",
    description: "",
    number_of_beds: 0,
    homestay_id: 0,
    price_per_day: 0,
    price_per_hour: 0,
  };
  selectedValue.value = null;
  errors.value = null;
};

const getHomestaysToSelect = () => {
  axios.get("v2/homestays/all").then((response) => {
    selectOptions.value = response.data.homestays;
  });
};


const getRoomTypesList = (page = 1) => {
  store
      .dispatch("roomTypes/fetchRoomTypes", {
        page,
      })
      .then((response) => {
        roomTypes.value = store.getters["roomTypes/getRoomTypesList"];
        pagination.value = response.pagination;
        isLoading.value = false;
      });
};

/**
 * todo: ADD ROOM TYPE
 */
const addRoomType = () => {
  isEditing.value = false;
  resetForm();
  $("#roomTypeFormModal").modal("show");
};

const addNewRoomType = () => {
  const formData = new FormData();
  isLoading.value = true;

  for (const key in model.value) {
    if (model.value.hasOwnProperty(key)) {
      const value = model.value[key];
      formData.append(key, value);
    }
  }

  axios
      .post("v2/room-types/create", formData)
      .then((response) => {
        successMessage.value = response.data.message;
        getRoomTypesList();
        isLoading.value = false;
        $("#roomTypeFormModal").modal("hide");
        $(".toast").toast("show");
        resetForm();
      })
      .catch((e) => {
        if (e.response) {
          isLoading.value = false;
          $("#roomTypeFormModal").modal("show");
          errors.value = e.response.data.errors;
        }
      });
};

/**
 * TODO: EDIT ROOM TYPE
 * @param {*} roomType
 */
const editRoomType = (roomType) => {
  isEditing.value = true;
  resetForm();
  $("#roomTypeFormModal").modal("show");
  model.value = {...roomType};
  if (roomType.room_prices && roomType.room_prices.length > 0) {
    const firstPrice = roomType.room_prices[0];
    model.value.homestay_id = firstPrice.homestay_id;
    model.value.price_per_day = firstPrice.price_per_day;
    model.value.price_per_hour = firstPrice.price_per_hour;
    selectedValue.value = {
      homestay_id: firstPrice.homestay_id,
      homestay_name: firstPrice.homestay_name,
    };
  }
};

const updateRoomType = () => {
  const formData = new FormData();
  isLoading.value = true;

  for (const key in model.value) {
    if (model.value.hasOwnProperty(key)) {
      const value = model.value[key];
      formData.append(key, value);
    }
  }

  axios
      .post(`v2/room-types/${model.value.room_type_id}/edit`, formData, {
        params: {_method: "put"},
      })
      .then((response) => {
        successMessage.value = response.data.message;
        getRoomTypesList();
        isLoading.value = false;
        $("#roomTypeFormModal").modal("hide");
        $(".toast").toast("show");
        resetForm();
      })
      .catch((e) => {
        if (e.response) {
          isLoading.value = false;
          $("#roomTypeFormModal").modal("show");
          errors.value = e.response.data.errors;
        }
      });
};

const roomTypeSubmit = () => {
  if (isEditing.value) {
    updateRoomType();
  } else {
    addNewRoomType();
  }
};

/**
 * TODO: DELETE ROOM TYPE
 * @param {*} roomType
 */
const deleteRoomType = (roomType) => {
  model.value = {...roomType};
  if (roomType.room_prices && roomType.room_prices.length > 0) {
    const firstPrice = roomType.room_prices[0];
    model.value.homestay_id = firstPrice.homestay_id;
    model.value.price_per_day = firstPrice.price_per_day;
    model.value.price_per_hour = firstPrice.price_per_hour;
    selectedValue.value = {
      homestay_id: firstPrice.homestay_id,
      homestay_name: firstPrice.homestay_name,
    };
  }
  $("#deleteConfirmModal").modal("show");
};

const handleDeleteRoomType = () => {
  isLoading.value = true;
  axios
      .delete(`v2/room-types/${model.value.room_type_id}/delete`)
      .then((response) => {
        getRoomTypesList();
        isLoading.value = false;
        successMessage.value = response.data.message;
        $("#deleteConfirmModal").modal("hide");
        $(".toast").toast("show");
      })
      .catch((e) => {
        if (e.response) {
          isLoading.value = false;
          alert(e.response.data.errors);
        }
      });
};

onBeforeMount(() => {
  getRoomTypesList();
  getHomestaysToSelect()
});

onMounted(() => {
  $("#roomTypeFormModal").on("hide.bs.modal", () => {
    errors.value = null;
    resetForm();
  });
});
</script>

<style scoped>
.rt-description {
  width: 40%;
}
</style>

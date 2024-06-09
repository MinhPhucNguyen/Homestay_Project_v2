<template>
  <ToastMessage :message="successMessage" />

  <div class="col-md-12">
    <div class="card">
      <div class="card-header bg-transparent border-0">
        <div class="d-inline-block fw-bold text-dark fs-4"></div>
        <router-link
          :to="{ name: 'admin.homestays' }"
          class="btn btn-danger fw-bold float-right"
        >
          <i class="fa-solid fa-arrow-left"></i>
          Quay về
        </router-link>
      </div>
      <div class="card-body mt-0">
        <form @submit.prevent="createNewHomestay">
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button
                class="nav-link text-success fw-bold active"
                id="home-tab"
                data-bs-toggle="tab"
                data-bs-target="#homestay-tab-pane"
                type="button"
                role="tab"
                aria-controls="homestay-tab-pane"
                aria-selected="true"
              >
                <i class="fa-solid fa-circle-info mr-1"></i>
                Thông tin Homestay
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button
                class="nav-link text-success fw-bold"
                id="profile-tab"
                data-bs-toggle="tab"
                data-bs-target="#facilities-tab-pane"
                type="button"
                role="tab"
                aria-controls="facilities-tab-pane"
                aria-selected="false"
              >
                <i class="fa-solid fa-list"></i>
                Tiện nghi
              </button>
            </li>
          </ul>
          <div class="tab-content" id="myTabContent">
            <div
              class="tab-pane fade show mt-3 active"
              id="homestay-tab-pane"
              role="tabpanel"
              aria-labelledby="homestay-tab"
              tabindex="0"
            >
              <div class="row">
                <div class="col-md-4 mb-3">
                  <label for="homestay_name">Tên Homestay</label>
                  <input
                    type="text"
                    name="homestay_name"
                    class="form-control"
                    v-model="model.homestay_name"
                  />
                  <small class="text-danger" v-if="errors.homestay_name">{{
                    errors.homestay_name[0]
                  }}</small>
                </div>
                <div class="col-md-4 mb-3">
                  <label for="email">Email</label>
                  <input
                    type="text"
                    name="email"
                    class="form-control"
                    v-model="model.email"
                  />
                  <small class="text-danger" v-if="errors.email">{{
                    errors.email[0]
                  }}</small>
                </div>
                <div class="col-md-4 mb-3">
                  <label for="phone">Số điện thoại</label>
                  <input
                    type="text"
                    name="phone"
                    class="form-control"
                    v-model="model.phone"
                  />
                  <small class="text-danger" v-if="errors.phone">{{
                    errors.phone[0]
                  }}</small>
                </div>
                <div class="col-md-4 mb-3">
                  <label for="address">Địa chỉ</label>
                  <input
                    type="text"
                    name="address"
                    class="form-control"
                    v-model="model.address"
                  />
                  <small class="text-danger" v-if="errors.address">{{
                    errors.address[0]
                  }}</small>
                </div>
                <div class="col-md-4 mb-3">
                  <label for="city">Thành phố</label>
                  <input
                    type="text"
                    name="city"
                    class="form-control"
                    v-model="model.city"
                  />
                  <small class="text-danger" v-if="errors.city">{{
                    errors.city[0]
                  }}</small>
                </div>
                <div class="col-md-4 mb-3">
                  <label for="status">Trạng thái</label>
                  <div class="d-flex align-items-center">
                    <input
                      type="checkbox"
                      name="status"
                      value="1"
                      v-model="isStatusChecked"
                    />
                    <label for="status" class="ml-2 mb-0">Hiển thị</label>
                  </div>
                </div>
                <div class="col-md-12 mb-3">
                  <label for="description">Description</label>
                  <ckeditorComponent
                    v-model="model.description"
                  ></ckeditorComponent>
                  <small class="text-danger" v-if="errors.description">{{
                    errors.description[0]
                  }}</small>
                </div>
              </div>
            </div>
            <div
              class="tab-pane fade mt-3"
              id="facilities-tab-pane"
              role="tabpanel"
              aria-labelledby="image-tab"
              tabindex="0"
            >
              <div class="row">
                <div class="mb-3">
                  <h5 class="mb-4">Chọn tiện nghi</h5>
                  <div class="facilities-list">
                    <div
                      name="facilities"
                      class="facility-item"
                      v-for="facility in facilitiesList"
                      :key="facility.facility_id"
                      @click="selectFacility($event, facility.facility_id)"
                    >
                      <img
                        v-if="facility.facility_icon"
                        :src="
                          'data:image/svg+xml;utf8,' + facility.facility_icon
                        "
                        width="20"
                        height="20"
                      />
                      <span>{{ facility.facility_name }}</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <button
            class="btn btn-success p-3 fw-bold float-end"
            type="submit"
            :disabled="isFilledForm"
          >
            <div
              class="spinner-border"
              role="status"
              style="width: 20px; height: 20px; margin-right: 10px"
              v-if="isLoading"
            >
              <span class="visually-hidden">Loading...</span>
            </div>
            Create
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import axios from "axios";
import ckeditorComponent from "@/components/Editor/index.vue";
import { ref, computed, watch, nextTick, onMounted } from "vue";
import { useStore } from "vuex";
import ToastMessage from "@/components/Toast/index.vue";
import { useRouter } from "vue-router";
import flatpickr from "flatpickr";
import "flatpickr/dist/themes/material_green.css";

const store = useStore();
const successMessage = ref(null);
const errors = ref({});
const isLoading = ref(false);
const router = useRouter();
const facilitiesList = ref([]);

const config = {
  enableTime: true,
  dateFormat: "d/m/Y H:i",
  altInput: true,
  altFormat: "d/m/Y H:i",
  allowInput: true,
  defaultDate: new Date(),
  defaultHour: new Date().getHours(),
};

const model = ref({
  homestay_name: "",
  description: "",
  email: "",
  phone: "",
  address: "",
  city: "",
  status: 0,
  stars: 5,
  facilitiesId: [],
});

onMounted(() => {
  axios.get("/v2/facilities/all").then((response) => {
    facilitiesList.value = response.data.facilities;
  });
});

/**
 * TODO: Select facility
 */
const selectFacility = (event, id) => {
  const item = event.target;
  if (item) {
    item.classList.toggle("facility-chose");
    if (item.classList.contains("facility-chose")) {
      model.value.facilitiesId.push(id);
    } else {
      const indexItemExist = model.value.facilitiesId.indexOf(id);
      model.value.facilitiesId.splice(indexItemExist, 1);
    }
  }
};

const isStatusChecked = computed({
  get() {
    return model.value.status === 1;
  },
  set(value) {
    model.value.status = value ? 1 : 0;
  },
});

/**
 * TODO: CREATE NEW CAR
 */
const isFilledForm = ref(true);

watch(model.value, () => {
  isFilledForm.value = false;
});

const createNewHomestay = async () => {
  const formData = new FormData();

  for (const key in model.value) {
    if (model.value.hasOwnProperty(key)) {
      //Xác định xem đối tượng có chứa thuộc tính được chỉ định hay không
      const value = model.value[key];
      if (Array.isArray(value)) {
        for (const item of value) {
          formData.append(`${key}[]`, item);
        }
      } else {
        formData.append(key, value);
      }
    }
  }

  isLoading.value = true;
  store
    .dispatch("homestays/createNewHomestay", formData)
    .then((response) => {
      successMessage.value = response.data.message;
      $(".toast").toast("show");
      isLoading.value = false;
      setTimeout(() => {
        router.push({ name: "admin.homestays" });
      }, 2000);
    })
    .catch((e) => {
      isLoading.value = false;
      if (e.response.status === 422) {
        console.log(e.response);
        errors.value = e.response.data.errors;
      }
    });
};
</script>

<style lang="scss" scoped>
/* FACILITIES TAB */
.facilities-list {
  width: 100%;
}

.facilities-list .facility-item {
  padding: 10px 20px;
  border-radius: 30px;
  background-color: #f1f1f1;
  display: inline-block;
  cursor: pointer;
  margin-right: 8px;
  margin-bottom: 10px;

  span {
    margin-left: 10px;
  }
}

.facilities-list .facility-item:hover {
  background-color: #37ecaa49;
  transition: 0.3s all ease-in-out;
  box-shadow: #1cc8898e 0px 0px 15px 0px;
}

.facility-chose {
  background-color: #1cc889d2 !important;
  font-weight: bold;
  color: white !important;
}
</style>

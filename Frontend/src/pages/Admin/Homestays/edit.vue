<template>
  <ToastMessage :message="successMessage"/>

  <div class="col-md-12">
    <div class="card">
      <div class="card-header bg-transparent border-0">
        <div class="d-inline-block fw-bold text-dark fs-4">
          Homestay:
        </div>
        <router-link :to="{ name: 'admin.homestays' }" class="btn btn-danger fw-bold float-right">
          <i class="fa-solid fa-arrow-left"></i>
          Quay lại
        </router-link>
      </div>
      <div class="card-body mt-0">
        <div v-if="formLoadingSuccess">
          <form @submit.prevent="updateHomestay">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link text-success fw-bold active" id="home-tab" data-bs-toggle="tab"
                        data-bs-target="#homestay-tab-pane" type="button" role="tab" aria-controls="homestay-tab-pane"
                        aria-selected="true">
                  <i class="fa-solid fa-circle-info mr-1"></i>
                  Thông tin Homestay
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link text-success fw-bold" id="profile-tab" data-bs-toggle="tab"
                        data-bs-target="#facilities-tab-pane" type="button" role="tab"
                        aria-controls="facilities-tab-pane"
                        aria-selected="false">
                  <i class="fa-solid fa-list"></i>
                  Tiện nghi
                </button>
              </li>
            </ul>
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show mt-3 active" id="homestay-tab-pane" role="tabpanel"
                   aria-labelledby="homestay-tab"
                   tabindex="0">
                <div class="row">
                  <div class="col-md-4 mb-3">
                    <label for="homestay_name">Tên Homestay</label>
                    <input type="text" name="homestay_name" class="form-control" v-model="model.homestay_name"/>
                    <small class="text-danger" v-if="errors.homestay_name">{{
                        errors.homestay_name[0]
                      }}</small>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label for="email">Email</label>
                    <input type="text" name="email" class="form-control" v-model="model.email"/>
                    <small class="text-danger" v-if="errors.email">{{
                        errors.email[0]
                      }}</small>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label for="phone">Số điện thoại</label>
                    <input type="text" name="phone" class="form-control" v-model="model.phone"/>
                    <small class="text-danger" v-if="errors.phone">{{
                        errors.phone[0]
                      }}</small>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label for="address">Địa chỉ</label>
                    <input type="text" name="address" class="form-control" v-model="model.address"/>
                    <small class="text-danger" v-if="errors.address">{{
                        errors.address[0]
                      }}</small>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label for="city">Thành phố</label>
                    <input type="text" name="city" class="form-control" v-model="model.city"/>
                    <small class="text-danger" v-if="errors.city">{{
                        errors.city[0]
                      }}</small>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label for="status">Trạng thái</label>
                    <div class="d-flex align-items-center">
                      <input type="checkbox" name="status" value="1" v-model="isStatusChecked"/>
                      <label for="status" class="ml-2 mb-0">Hiển thị</label>
                    </div>
                  </div>
                  <div class="col-md-12 mb-3">
                    <label for="description">Description</label>
                    <ckeditorComponent v-model="model.description"></ckeditorComponent>
                    <small class="text-danger" v-if="errors.description">{{
                        errors.description[0]
                      }}</small>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade mt-3" id="facilities-tab-pane" role="tabpanel" aria-labelledby="image-tab"
                   tabindex="0">
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <h5 class="mb-4">Chọn tiện nghi</h5>
                    <div class="facilities-list">
                      <div v-for="facility in facilitiesList" name="facilities" class="facility-item"
                           :class="{'facility-chose': model.facilitiesId.includes(facility.facility_id)}"
                           :key="facility.facility_id"
                           @click="selectFacility($event, facility.facility_id)">
                        {{ facility.facility_name }}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <button class="btn btn-success p-3 fw-bold float-end" type="submit" :disabled="isFilledForm">
              <div class="spinner-border" role="status" style="width: 20px; height: 20px; margin-right: 10px"
                   v-if="isLoading">
                <span class="visually-hidden">Loading...</span>
              </div>
              Lưu thay đổi
            </button>
          </form>
        </div>
        <div v-else>
          <stateLoading/>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import ckeditorComponent from "@/components/Editor/index.vue";
import {ref, computed, watch} from "vue";
import {useStore} from "vuex";
import ToastMessage from "@/components/Toast/index.vue";
import {useRouter} from "vue-router";
import axios from "axios";
import MyModal from "@/components/Modal/Modal.vue";
import stateLoading from "@/components/Loading/Loading.vue";

const store = useStore();
const facilitiesList = ref([]);
const successMessage = ref(null);
const errors = ref({});
const isLoading = ref(false);
const isRemoveImageLoading = ref(false);
const router = useRouter();
const homestayId = router.currentRoute.value.params.id;
const imagesUrl = ref([]);

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

store.dispatch("homestays/fetchFacilities").then(() => {
  facilitiesList.value = store.getters["homestays/getFacilitiesList"];
});

const isFacilitySelected = (facilityId) =>{
  return model.facilitiesId.includes(facilityId);
}

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

const getHomestayById = async () => {
  return await axios
      .get(`v2/homestays/${homestayId}/edit`)
      .then(({data}) => {
        for (const key in model.value) {
          if (model.value.hasOwnProperty(key)) {
            if (Array.isArray(model.value[key])) {
              if (key === "facilitiesId") {
                const facilities = data.homestay.facilities;
                const getFacilitiesIdList = facilities.map((facility) => facility.facility_id);
                for (const id of getFacilitiesIdList) {
                  model.value[key].push(id);
                }
              }
            }
            else{
              model.value[key] = data.homestay[key];
            }
          }
        }
      })
      .catch((e) => {
        if (e.response) {
          alert("Something wrong, please try again");
        }
      });
};
getHomestayById();

const formLoadingSuccess = ref(false);
watch(model.value, () => {
  formLoadingSuccess.value = true;
});

// /**
//  * TODO: Update homestay
//  */
const isFilledForm = ref(true);

watch(model.value, () => {
  isFilledForm.value = false;
});

const updateHomestay = async () => {
  isLoading.value = true;
  const formData = new FormData();

  for (const key in model.value) {
    if (model.value.hasOwnProperty(key)) {
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

  imagesUrl.value = [];
  await axios
      .post(`v2/homestays/${homestayId}/update`, formData)
      .then((response) => {
        successMessage.value = response.data.message;
        $(".toast").toast("show");
        isLoading.value = false;
      })
      .catch((e) => {
        isLoading.value = false;
        if (e.response) {
          console.log(e.response.data);
          errors.value = e.response.data.errors;
        }
      });
};
</script>

<style lang="scss" scope>
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
}

.facilities-list .facility-item:hover{
  background-color: #37ecaa49;
  transition: 0.3s all ease-in-out;
  box-shadow: #1cc8898e 0px 0px 15px 0px;
}

.facility-chose{
  background-color: #1cc889d2 !important;
  font-weight: bold;
  color: white !important;
}
</style>

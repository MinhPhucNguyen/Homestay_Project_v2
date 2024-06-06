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
                <button class="nav-link text-success fw-bold" id="room-tab" data-bs-toggle="tab"
                        data-bs-target="#rooms-tab-pane" type="button" role="tab" aria-controls="rooms-tab-pane"
                        aria-selected="true">
                  <i class="fa-solid fa-door-open"></i>
                  Phòng
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
              <li class="nav-item" role="presentation">
                <button class="nav-link text-success fw-bold" id="profile-tab" data-bs-toggle="tab"
                        data-bs-target="#image-tab-pane" type="button" role="tab" aria-controls="image-tab-pane"
                        aria-selected="false">
                  <i class="fa-solid fa-image mr-1"></i>
                  Thêm ảnh
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


              <!--              <div class="tab-pane fade mt-3" id="feature-tab-pane" role="tabpanel" aria-labelledby="image-tab"-->
              <!--                   tabindex="0">-->
              <!--                <div class="row">-->
              <!--                  <div class="col-md-6 mb-3">-->
              <!--                    <h5 class="mb-4">Select Features</h5>-->
              <!--                    <div class="features-list">-->
              <!--                      <div name="features" v-for="feature in featuresList" class="feature-item" :class="{-->
              <!--                                    'feature-chose': model.featuresId.includes(feature.id),-->
              <!--                                 }" :key="feature.id" @click="selectFeature($event, feature.id)">-->
              <!--                        {{ feature.name }}-->
              <!--                      </div>-->
              <!--                      <input type="hidden" class="featuresChose"/>-->
              <!--                    </div>-->
              <!--                  </div>-->
              <!--                </div>-->
              <!--              </div>-->
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
const featuresList = ref([]);
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
  rooms: [
    {
      room_number: "",
      homestay_id: 0,
      room_type_id: 0,
      status: "0",
    },
  ]
});

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
            model.value[key] = data.homestay[key];
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
.priod-input {
  margin-bottom: 30px;
}

.priod-item {
  width: 50%;
  display: flex;
  align-items: center;
  gap: 50px;
  border-bottom: 1px solid #ddd;
  margin-bottom: 40px;
  padding-bottom: 40px;

  .from,
  .to {
    display: flex;
    flex-direction: column;
    width: 50%;
  }

  .remove-period {
    font-size: 25px;
    color: #e74a3b;
    cursor: pointer;
  }
}

.add-period {
  margin-top: 20px;
  display: flex;
  justify-content: center;

  .add-period-wrapper {
    width: 50%;

    a {
      border: 2px solid #1cc88a;
      color: #1cc88a;
      cursor: pointer;
      font-size: 25px;
      width: 42px;
      height: 42px;
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
      text-decoration: none;

      &:hover {
        color: #1cc88a;
      }
    }
  }
}
</style>

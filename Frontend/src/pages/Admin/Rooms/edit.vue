<template>
  <!--  <ToastMessage :message="successMessage" />-->

  <div class="col-md-12">
    <div class="card">
      <div class="card-header bg-transparent border-0">
        <div class="d-inline-block fw-bold text-dark fs-4">Room:</div>
        <router-link
            :to="{ name: 'admin.rooms' }"
            class="btn btn-danger fw-bold float-right"
        >
          <i class="fa-solid fa-arrow-left"></i>
          Quay lại
        </router-link>
      </div>
      <div class="card-body mt-0">
        <div v-if="formLoadingSuccess">
          <form @submit.prevent="updateRoom">
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
                  Thông tin Room
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
                  Ảnh Room
                </button>
              </li>
            </ul>
            <div class="row">
              <div class="col-md-4 mb-3">
                <label for="room_number">Tên Homestay</label>
                <input
                    type="text"
                    name="room_number"
                    class="form-control"
                    v-model="model.room_number"
                />
                <!--                    <small class="text-danger" v-if="errors.homestay_name">{{-->
                <!--                        errors.homestay_name[0]-->
                <!--                      }}</small>-->
              </div>
              <div class="col-md-4 mb-3">
                <label for="room_type">Room Type</label>
                <select class="form-select" v-model="model.room_type_id" name="room_type_id" id="room_type">
                  <option>Select</option>
                  <!--                  <option :value="type">{{ typeConvert(type) }}</option>-->
                </select>
                <!--                    <small class="text-danger" v-if="errors.email">{{-->
                <!--                        errors.email[0]-->
                <!--                      }}</small>-->
              </div>
              <div class="col-md-12 mb-3">
                <label for="description">Mô tả</label>
                <ckeditorComponent
                    v-model="model.description"
                ></ckeditorComponent>
              </div>
              <div class="col-md-4 mb-3">
                <label for="status">Trạng thái</label>
                <div class="d-flex align-items-center">
                  <select v-model="model.status" id="status" name="status" class="form-select" required>
                    <option selected disabled value="">Chọn trạng thái</option>
                    <option value="available">Phòng trống</option>
                    <option value="booked">Phòng đã đặt</option>
                    <option value="cleaned">Đã dọn dẹp</option>
                    <option value="not_cleand">Chưa dọn dẹp</option>
                    <option value="under_repair">Sửa chữa</option>
                  </select>
                </div>
              </div>
              <span class="visually-hidden">Loading...</span>
              <input
                  class="btn btn-success p-3 fw-bold float-end"
                  type="submit"
                  :disabled="isInvalidForm"
                  value=" Lưu thay đổi"
                  name="submitRoom"
              />
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>

import {ref, watch} from "vue";
import ckeditorComponent from "@/components/Editor/index.vue";

const isInvalidForm = ref(true)
const model = ref({
  description: '',
  room_type_id: 0,
  status: 1,
  room_number: 1
})
const formLoadingSuccess = ref(true);
// watch(model.value, () => {
//   formLoadingSuccess.value = true;
// });

</script>
<template>
  <div
      class="modal fade"
      id="addRoomModal"
      tabindex="-1"
      aria-labelledby="roomTypeFormModalLabel"
      aria-hidden="true"
  >
    <div class="modal-dialog add-room-modal">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="roomTypeFormModalLabel">
            Thêm phòng cho <strong> </strong>
          </h1>
          <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <form>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <button
                    class="nav-link text-success fw-bold active"
                    id="home-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#room-tab-pane"
                    type="button"
                    role="tab"
                    aria-controls="room-tab-pane"
                    aria-selected="true"
                >
                  <i class="fa-solid fa-circle-info mr-1"></i>
                  Thông tin phòng
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button
                    class="nav-link text-success fw-bold"
                    id="profile-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#images-tab-pane"
                    type="button"
                    role="tab"
                    aria-controls="images-tab-pane"
                    aria-selected="false"
                >
                  <i class="fa-solid fa-list"></i>
                  Thêm ảnh
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
            <!--            <div class="tab-content" id="myTabContent">-->
            <!--              <div-->
            <!--                  class="tab-pane fade show mt-3 active"-->
            <!--                  id="homestay-tab-pane"-->
            <!--                  role="tabpanel"-->
            <!--                  aria-labelledby="homestay-tab"-->
            <!--                  tabindex="0"-->
            <!--              >-->
            <!--                <div class="row">-->
            <!--                  <div class="col-md-4 mb-3">-->
            <!--                    <label for="homestay_name">Tên Homestay</label>-->
            <!--                    <input-->
            <!--                        type="text"-->
            <!--                        name="homestay_name"-->
            <!--                        class="form-control"-->
            <!--                        v-model="model.homestay_name"-->
            <!--                    />-->
            <!--                    <small class="text-danger" v-if="errors.homestay_name">{{-->
            <!--                        errors.homestay_name[0]-->
            <!--                      }}</small>-->
            <!--                  </div>-->
            <!--                  <div class="col-md-4 mb-3">-->
            <!--                    <label for="email">Email</label>-->
            <!--                    <input-->
            <!--                        type="text"-->
            <!--                        name="email"-->
            <!--                        class="form-control"-->
            <!--                        v-model="model.email"-->
            <!--                    />-->
            <!--                    <small class="text-danger" v-if="errors.email">{{-->
            <!--                        errors.email[0]-->
            <!--                      }}</small>-->
            <!--                  </div>-->
            <!--                  <div class="col-md-4 mb-3">-->
            <!--                    <label for="phone">Số điện thoại</label>-->
            <!--                    <input-->
            <!--                        type="text"-->
            <!--                        name="phone"-->
            <!--                        class="form-control"-->
            <!--                        v-model="model.phone"-->
            <!--                    />-->
            <!--                    <small class="text-danger" v-if="errors.phone">{{-->
            <!--                        errors.phone[0]-->
            <!--                      }}</small>-->
            <!--                  </div>-->
            <!--                  <div class="col-md-4 mb-3">-->
            <!--                    <label for="address">Địa chỉ</label>-->
            <!--                    <input-->
            <!--                        type="text"-->
            <!--                        name="address"-->
            <!--                        class="form-control"-->
            <!--                        v-model="model.address"-->
            <!--                    />-->
            <!--                    <small class="text-danger" v-if="errors.address">{{-->
            <!--                        errors.address[0]-->
            <!--                      }}</small>-->
            <!--                  </div>-->
            <!--                  <div class="col-md-4 mb-3">-->
            <!--                    <label for="city">Thành phố</label>-->
            <!--                    <input-->
            <!--                        type="text"-->
            <!--                        name="city"-->
            <!--                        class="form-control"-->
            <!--                        v-model="model.city"-->
            <!--                    />-->
            <!--                    <small class="text-danger" v-if="errors.city">{{-->
            <!--                        errors.city[0]-->
            <!--                      }}</small>-->
            <!--                  </div>-->
            <!--                  <div class="col-md-4 mb-3">-->
            <!--                    <label for="status">Trạng thái</label>-->
            <!--                    <div class="d-flex align-items-center">-->
            <!--                      <input-->
            <!--                          type="checkbox"-->
            <!--                          name="status"-->
            <!--                          value="1"-->
            <!--                          v-model="isStatusChecked"-->
            <!--                      />-->
            <!--                      <label for="status" class="ml-2 mb-0">Hiển thị</label>-->
            <!--                    </div>-->
            <!--                  </div>-->
            <!--                  <div class="col-md-12 mb-3">-->
            <!--                    <label for="description">Description</label>-->
            <!--                    <ckeditorComponent-->
            <!--                        v-model="model.description"-->
            <!--                    ></ckeditorComponent>-->
            <!--                    <small class="text-danger" v-if="errors.description">{{-->
            <!--                        errors.description[0]-->
            <!--                      }}</small>-->
            <!--                  </div>-->
            <!--                </div>-->
            <!--              </div>-->
            <!--              <div-->
            <!--                  class="tab-pane fade mt-3"-->
            <!--                  id="facilities-tab-pane"-->
            <!--                  role="tabpanel"-->
            <!--                  aria-labelledby="image-tab"-->
            <!--                  tabindex="0"-->
            <!--              >-->
            <!--                <div class="row">-->
            <!--                  <div class="mb-3">-->
            <!--                    <h5 class="mb-4">Chọn tiện nghi</h5>-->
            <!--                    <div class="facilities-list">-->
            <!--                      <div-->
            <!--                          name="facilities"-->
            <!--                          class="facility-item"-->
            <!--                          v-for="facility in facilitiesList"-->
            <!--                          :key="facility.facility_id"-->
            <!--                          @click="selectFacility($event, facility.facility_id)"-->
            <!--                      >-->
            <!--                        <img-->
            <!--                            v-if="facility.facility_icon"-->
            <!--                            :src="-->
            <!--                          'data:image/svg+xml;utf8,' + facility.facility_icon-->
            <!--                        "-->
            <!--                            width="20"-->
            <!--                            height="20"-->
            <!--                        />-->
            <!--                        <span>{{ facility.facility_name }}</span>-->
            <!--                      </div>-->
            <!--                    </div>-->
            <!--                  </div>-->
            <!--                </div>-->
            <!--              </div>-->
            <!--            </div>-->
            <button
                class="btn btn-success p-3 fw-bold float-end"
                type="submit"
                :disabled="isLoading"
            >
              <div
                  class="spinner-border"
                  role="status"
                  style="width: 20px; height: 20px; margin-right: 10px"
                  v-if="isLoading"
              >
                <span class="visually-hidden">Loading...</span>
              </div>
              Lưu phòng mới
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import ckeditorComponent from "@/components/Editor/index.vue";
import {onBeforeMount, onMounted, ref, watch, defineProps} from "vue";
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
const successMessage = ref(null);
const isLoading = ref(false);
const pagination = ref({});

const homestay = ref(null);

const props = defineProps({
  homestayId: {
    type: Number,
    required: true,
  }
});

// const getHomestayById = async () => {
//   const homestay = await store.dispatch("homestays/fetchHomestayById", props.homestayId);
//   console.log(homestay);
// };
//
// onMounted(() => {
//   getHomestayById();
// });

</script>

<style scoped>
.add-room-modal {
  width: 1700px !important;
}

@media (min-width: 576px) {
  .modal-dialog {
    max-width: 1700px;
    margin: 1.75rem auto;
  }
}

.modal-body-custome {
  max-height: 750px;
  overflow-y: scroll;
  scrollbar-width: thin;
}
</style>
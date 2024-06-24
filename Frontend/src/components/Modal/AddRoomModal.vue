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
            Thêm phòng cho homestay <strong>{{ homestay ? homestay.homestay_name : '' }}</strong>
          </h1>
          <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <form enctype="multipart/form-data" @submit.prevent="submitFormRoom" method="post">
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
            <div class="tab-content" id="myTabContent">
              <div
                  class="tab-pane fade show mt-3 active"
                  id="room-tab-pane"
                  role="tabpanel"
                  aria-labelledby="room-tab"
                  tabindex="0"
              >
                <div class="row">
                  <div class="col-md-4 mb-3">
                    <label for="room_number">Số phòng</label>
                    <input
                        type="text"
                        name="room_number"
                        class="form-control"
                        v-model="model.room_number"
                    />
                    <!--                                  <small class="text-danger" v-if="errors.room_number">{{-->
                    <!--                                      errors.room_number[0]-->
                    <!--                                    }}</small>-->
                  </div>
                  <div class="col-md-4 mb-3">
                    <label for="status">Loại phòng</label>
                    <div class="d-flex align-items-center">
                      <select class="form-select">
                        <option selected disabled>Chọn loại phòng</option>
                        <option v-for="type in roomTypes" :key="type.room_type_id" :value="type.room_type_id">
                          {{ type.name }}
                        </option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label for="status">Trạng thái</label>
                    <div class="d-flex align-items-center">
                      <select class="form-select">
                        <option selected disabled>Chọn trạng thái</option>
                        <option value="available">Phòng trống</option>
                        <option value="booked">Phòng đã đặt</option>
                        <option value="cleaned">Đã dọn dẹp</option>
                        <option value="not_cleand">Chưa dọn dẹp</option>
                        <option value="under_repair">Sửa chữa</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-12 mb-3">
                    <div class="priod-input">
                      <div class="priod-item">
                        <div class="start-date">
                          <label for="start-date">Bắt đầu</label>
                          <input id="start-date" name="start-date" type="datetime-local"
                                 class="form-control datetime-input fw-bold p-4 text-black"/>
                        </div>
                        <div class="end-date">
                          <label for="end-date">Kết thúc</label>
                          <input id="end-date" name="end-date" type="datetime-local"
                                 class="form-control datetime-input fw-bold p-4 text-black"/>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12 mb-3">
                    <label for="description">Mô tả</label>
                    <ckeditorComponent
                        v-model="model.description"
                    ></ckeditorComponent>
                    <!--                                  <small class="text-danger" v-if="errors.description">{{-->
                    <!--                                      errors.description[0]-->
                    <!--                                    }}</small>-->
                  </div>
                </div>
              </div>
              <div class="tab-pane fade mt-3" id="images-tab-pane" role="tabpanel" aria-labelledby="images-tab"
                   tabindex="0">
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <h5 class="mb-4">Đăng ảnh phòng</h5>
                    <input ref="filesInput" type="file" multiple name="image[]" class="form-control file-input"
                           @change="uploadRoomImage" value="" />
                    <div class="display_image mb-4 mt-4" v-if="imagesUrl.length > 0">
                      <div class="room_image_input" v-for="(src, index) in imagesUrl" :key="index">
                        <img :src="src" alt="" class="image_input"/>
                        <button class="btn btn-danger remove_btn" @click.prevent="removeImage(src,index)">
                          Remove
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div
                  class="tab-pane fade mt-3"
                  id="facilities-tab-pane"
                  role="tabpanel"
                  aria-labelledby="facilities-tab"
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
            <input
                class="btn btn-success p-3 fw-bold float-end"
                type="submit"
                :disabled="isInvalidForm"
                value=" Lưu phòng mới"
                name="submitRoom"
            />
              <div
                  class="spinner-border"
                  role="status"
                  style="width: 20px; height: 20px; margin-right: 10px"
                  v-if="isLoading"
              >
                <span class="visually-hidden">Loading...</span>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import ckeditorComponent from "@/components/Editor/index.vue";
import {onMounted, ref, watch, defineProps} from "vue";
import axios from "axios";
import {useStore} from "vuex";
import flatpickr from "flatpickr";
import "flatpickr/dist/themes/material_green.css";

const store = useStore();
const roomTypes = ref([]);
const model = ref({
  room_number: "",
  homestay_id: props.homestay.homestay_id,
  room_type_id: 0,
  description: "",
  status: "",
  facilitiesId: [],
  room_images: [],
});
const errors = ref(null);
const successMessage = ref(null);
const isLoading = ref(false);
const pagination = ref({});
const isInvalidForm = ref(true);

const config = {
  enableTime: true,
  dateFormat: "d/m/Y H:i",
  altInput: true,
  altFormat: "d/m/Y H:i",
  allowInput: true,
  minDate: "today",
  minTime: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
  defaultDate: new Date(),
  defaultHour: new Date().getHours(),
};

const submitFormRoom = async (e) => {

  let formData = new FormData();
  axios.post('/v2/rooms/create',model.value).then((response) => {
          console.log(response);
      })
      .catch((e) => {
        console.log(e);
      });
}

const props = defineProps({
  homestay: {
    type: Object,
    required: true,
  },
  facilitiesList: {
    type: Array,
    required: true,
  },
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

/**
 * TODO: display image
 */
const filesInput = ref(null);
const imagesUrl = ref([]);

const uploadRoomImage = (event) => {
  for (const file of event.target.files) {
    const imageURL = URL.createObjectURL(file);
    imagesUrl.value.push(imageURL);
    model.value.room_images.push(file);
  }
};

/**
 * TODO: Remove room image before create room car
 * @param {*} index
 */
const removeImage = (url,index) => {
   if(imagesUrl._rawValue[0] === url) {
    model.value.room_images.splice(0,1);
   }
  const newFileList = new DataTransfer();
  for (let i = 0; i < filesInput.value.files.length; i++) {
    if (i !== index) {
      newFileList.items.add(filesInput.value.files[i]);
    }
  }
  filesInput.value.files = newFileList.files;
};

/**
 * TODO: Get room types by homestay id
 */

const getRoomTypes = () => {
  isLoading.value = true;
  axios
      .get(`/v2/room-types/getByHomestay/${props.homestay.homestay_id}`)
      .then((response) => {
        roomTypes.value = response.data.roomTypes;
        isLoading.value = false;
      })
      .catch((e) => {
        console.log(e);
      });
}

onMounted(() => {
  getRoomTypes();
});

watch(model.value, () => {
  isInvalidForm.value = false;
});

watch(() => props.homestay, () => {
  getRoomTypes();
  model.value.homestay_id = props.homestay.homestay_id;
});

onMounted(() => {
  $("#addRoomModal").on("hide.bs.modal", () => {
    errors.value = null;
    model.value = {
      room_number: "",
      homestay_id: props.homestay.homestay_id,
      room_type_id: 0,
      description: "",
      status: "",
      facilitiesId: [],
      room_images: [],
    };
    imagesUrl.value = [];
  });
});

/**
 * TODO: Add datetime picker to input
 */
const fromInput = ref(null);
const toInput = ref(null);
onMounted(() => {
  fromInput.value = document.querySelector(`#start-date`);
  toInput.value = document.querySelector(`#end-date`);
  flatpickr(fromInput.value, config);
  flatpickr(toInput.value, config);
});

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

.display_image {
  gap: 20px;
}

.room_image_input {
  display: flex;
  gap: 20px;
  align-items: center;
  flex-direction: column;
}

.room_image_input > .image_input {
  width: 120px;
  height: 120px;
  object-fit: cover;
}

.priod-input {
  display: flex;
  justify-content: center;
}

.priod-item {
  display: flex;
  align-items: center;
  gap: 26px;

  .start-date,
  .end-date {
    display: flex;
    flex-direction: column;
    width: 100%;
  }
}
</style>
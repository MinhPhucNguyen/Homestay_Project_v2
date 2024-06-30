<template>
  <ToastMessage :message="successMessage"/>

  <div class="col-md-12">
    <div class="card">
      <div class="card-header bg-transparent border-0">
        <div class="d-inline-block fw-bold text-dark fs-4">Danh sách Homestays</div>
        <router-link :to="{ name: 'homestays.create' }" class="btn btn-success fw-bold float-right">
          <i class="fa-solid fa-plus"></i>
          Thêm Homestay
        </router-link>
      </div>
      <div class="card-body mt-0 w-100">
        <div class="mb-3 d-flex align-items-center justify-content-between">
          <div class="w-25 mt-3 d-flex align-items-center">
            <i class="fa-solid fa-magnifying-glass fs-5 mr-2"></i>
            <input type="text" name="search" class="form-control small search-input border border-dark-subtletext-dark"
                   placeholder="Tìm kiếm ..." v-model="searchInput"/>
          </div>
        </div>
        <table class="table table-bordered table-striped text-dark fw-bold">
          <thead>
          <tr class="text-dark">
            <th data-sort="homestay_id" @click.prevent="changeSort('homestay_id')">
              ID
              <span class="sort-id-icon float-end">
                           <i class="fa-solid fa-arrow-down" :class="{
                              'text-success': sort_direction == 'desc' && sort_field == 'homestay_id',
                           }"></i>
                           <i class="fa-solid fa-arrow-up" :class="{
                              'text-success': sort_direction == 'asc' && sort_field == 'homestay_id',
                           }"></i>
                        </span>
            </th>
            <th class="text-center" @click.prevent="changeSort('homestay_name')">
              Tên Homestay
              <span class="sort-id-icon float-end">
                           <i class="fa-solid fa-arrow-down" :class="{
                              'text-success':
                                 sort_direction == 'desc' && sort_field == 'homestay_name',
                           }"></i>
                           <i class="fa-solid fa-arrow-up" :class="{
                              'text-success':
                                 sort_direction == 'asc' && sort_field == 'homestay_name',
                           }"></i>
                        </span>
            </th>
            <th class="text-center">Số điện thoại</th>
            <th class="text-center">Email</th>
            <th class="text-center">Địa chỉ</th>
            <th class="text-center">Thành phố</th>
            <th class="text-center">Trạng thái</th>
            <th class="text-center">Action</th>
          </tr>
          </thead>
          <tbody id="body-table">
          <tr v-for="homestay in homestaysList" :key="homestay.homestay_id">
            <td class="text-center">{{ homestay.homestay_id }}</td>
            <td class="text-center">
              <a href="" class="text-success text-decoration-none">{{ homestay.homestay_name }}</a>
            </td>
            <td class="text-center">{{ homestay.phone }}</td>
            <td class="text-center">{{ homestay.email }}</td>
            <td class="text-center">{{ homestay.address }}</td>
            <td class="text-center">{{ homestay.city }}</td>
            <td class="text-center">{{ homestay.status ? 'Hiện thị' : 'Ẩn' }}</td>
            <td class="text-center">
              <div class="dropdown">
                <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                  Action
                </button>
                <ul class="dropdown-menu">
                  <li>
                    <button type="button" class="dropdown-item mb-3 fs-6 text-warning bg-white"
                            @click="openRoomsList(homestay.homestay_id)">
                      <i class="fa-solid fa-list"></i>
                      <span class="ml-2">QL Phòng</span>
                    </button>
                  </li>
                  <li>
                    <button type="button" class="dropdown-item mb-3 fs-6 text-warning bg-white"
                            @click="openAddNewRoomModal(homestay.homestay_id)">
                      <i class="fa-solid fa-plus"></i>
                      <span class="ml-2">Thêm phòng</span>
                    </button>
                  </li>
                  <li>
                    <router-link :to="{ name: 'homestays.edit', params: { id: homestay.homestay_id } }"
                                 class="dropdown-item mb-3 fs-6 text-primary bg-white">
                      <i class="fa-solid fa-pen-to-square"></i>
                      <span class="ml-2">Sửa</span>
                    </router-link>
                  </li>
                  <li>
                    <button type="button" class="dropdown-item fs-6 text-danger bg-white"
                            @click="deleteHomestay(homestay.homestay_id)">
                      <i class="fa-solid fa-trash"></i>
                      <span class="ml-2">Xóa</span>
                    </button>
                  </li>
                </ul>
              </div>
            </td>

            <my-modal @clickTo="handleDeleteHomestay(homestay.homestay_id)"
                      :idModal="`deleteConfirmModal${homestay.homestay_id}`"
                      bgColor="danger">
              <template v-slot:title>Xác nhận xóa homestay</template>
              <h6 class="text-dark text-center fs-5 mt-4">
                Bạn có chắc chắn muốn xóa homestay này không?
              </h6>
              <template v-slot:buttonName>
                <div class="spinner-border" role="status" style="width: 24px; height: 24px; margin-right: 10px"
                     v-if="isLoading">
                  <span class="visually-hidden">Loading...</span>
                </div>
                Xóa
              </template>
            </my-modal>
          </tr>
          <tr v-if="isLoading && !homestaysList.length">
            <td colspan="12" class="text-center">
              <stateLoading/>
            </td>
          </tr>
          <tr v-if="isNotFound && !isLoading">
            <td colspan="12" class="text-center">Không có homestay</td>
          </tr>

          <RoomsListModal v-if="selectedhomestayId" :homestayId="selectedhomestayId"/>
          <AddRoomModal v-if="selectedHomestay" :facilitiesList="facilitiesList" :homestay="selectedHomestay"/>

          </tbody>
        </table>
        <div class="pagination">
          <Pagination :pagination="pagination" @pagination-page="getHomestaysList"/>
        </div>
      </div>
    </div>
  </div>

</template>

<script setup>
import {computed, onBeforeMount, onMounted, ref, watch, nextTick} from "vue";
import {useStore} from "vuex";
import stateLoading from "@/components/Loading/Loading.vue";
import MyModal from "@/components/Modal/Modal.vue";
import ToastMessage from "@/components/Toast/index.vue";
import Pagination from "@/components/Pagination/index.vue";
import {debounce} from "@/utils/debounce.js";
import AddRoomModal from "@/components/Modal/AddRoomModal.vue";
import RoomsListModal from "@/components/Modal/RoomsListModal.vue";
import axios from "axios";

const store = useStore();
const homestaysList = ref([]);
const isLoading = ref(false);
const successMessage = ref(null);
const pagination = ref({});
const sort_direction = ref("desc");
const sort_field = ref("homestay_id");
const searchInput = ref("");
const selectedHomestay = ref(null);
const facilitiesList = ref([]);
const selectedhomestayId = ref(null);

onMounted(() => {
  axios.get("/v2/facilities/all").then((response) => {
    facilitiesList.value = response.data.facilities;
  });
});

const getHomestaysList = (page = 1) => {
  isLoading.value = true;
  store
      .dispatch("homestays/fetchHomestays", {
        page,
        sort_field,
        sort_direction,
        searchInput,
      })
      .then((res) => {
        homestaysList.value = store.getters["homestays/getHomestaysList"];
        pagination.value = res.pagination;
        isLoading.value = false;
      });
};

const isNotFound = computed(() => (homestaysList.value.length === 0 ? true : false));

onBeforeMount(() => {
  getHomestaysList();
});

const deleteHomestay = (id) => {
  $(`#deleteConfirmModal${id}`).modal("show");
};

const handleDeleteHomestay = (id) => {
  isLoading.value = true;
  store
      .dispatch("homestays/deleteHomestay", id)
      .then((response) => {
        isLoading.value = false;
        $(`#deleteConfirmModal${id}`).modal("hide");
        successMessage.value = response.data.message;
        getHomestaysList().then(() => {
          $(".toast").toast("show");
        });
      })
      .catch((e) => {
        if (e.response) {
          isLoading.value = false;
          alert(e.response.data.errors);
        }
      });
};

const debouncedGetHomestaysList = debounce(getHomestaysList, 300);

watch(searchInput, () => {
  debouncedGetHomestaysList();
});

const changeSort = (field) => {
  if (sort_field.value == field) {
    sort_direction.value = sort_direction.value == "asc" ? "desc" : "asc";
  } else {
    sort_field.value = field;
  }
  getHomestaysList();
};

const openAddNewRoomModal = async (homestayId) => {
  try {
    const response = await store.dispatch("homestays/fetchHomestayById", homestayId);
    if (response) {
      selectedHomestay.value = response;
      await nextTick();
      $("#addRoomModal").modal("show");
    }
  } catch (e) {
    console.log(e);
  }
};

const openRoomsList = async (homestayId) => {
  selectedhomestayId.value = homestayId;
  await nextTick();
  $("#roomsListModal").modal("show");
};
</script>

<style></style>

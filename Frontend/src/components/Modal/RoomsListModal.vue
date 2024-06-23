<template>
  <div
      class="modal fade"
      id="roomsListModal"
      tabindex="-1"
      aria-labelledby="roomsListFormModalLabel"
      aria-hidden="true"
  >
    <div class="modal-dialog rooms-list-modal">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="roomTypeFormModalLabel">
            Danh sách phòng
          </h1>
          <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <router-link :to="{ name: 'homestays.create' }" class="btn btn-success fw-bold float-right">
            <i class="fa-solid fa-plus"></i>
            Thêm phòng
          </router-link>
          <div class="mt-4">
            <div class="mb-3 d-flex align-items-center justify-content-between">
              <div class="w-25 mt-3 d-flex align-items-center">
                <i class="fa-solid fa-magnifying-glass fs-5 mr-2"></i>
                <input type="text" name="search"
                       class="form-control small search-input border border-dark-subtletext-dark"
                       placeholder="Tìm kiếm ..." v-model="searchInput"/>
              </div>
            </div>
            <table class="table table-bordered table-striped text-dark fw-bold">
              <thead>
              <tr class="text-dark">
                <th class="text-center" @click.prevent="changeSort('room_number')">
                  Số phòng
                  <span class="sort-id-icon float-end">
                           <i class="fa-solid fa-arrow-down" :class="{
                              'text-success':
                                 sort_direction == 'desc' && sort_field == 'room_number',
                           }"></i>
                           <i class="fa-solid fa-arrow-up" :class="{
                              'text-success':
                                 sort_direction == 'asc' && sort_field == 'room_number',
                           }"></i>
                        </span>
                </th>
                <th class="text-center">Mô tả</th>
                <th class="text-center">Loại phòng</th>
                <th class="text-center">Trạng thái</th>
                <th class="text-center">Action</th>
              </tr>
              </thead>
              <tbody id="body-table">
              <tr v-for="room in roomsList" :key="room.room_id">
                <td class="text-center">{{ room.room_number }}</td>
                <td class="text-center">
                  <a href="" class="text-success text-decoration-none">{{ room.description }}</a>
                </td>
                <th class="text-center">{{ room.room_type.name }}</th>
                <td class="text-center">{{ room.status }}</td>
                <td class="text-center">
                  <div class="dropdown">
                    <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                      Action
                    </button>
                    <ul class="dropdown-menu">
                      <!--                      <li>-->
                      <!--                        <router-link :to="{ name: 'homestays.edit', params: { id: homestay.homestay_id } }"-->
                      <!--                                     class="dropdown-item mb-3 fs-6 text-primary bg-white">-->
                      <!--                          <i class="fa-solid fa-pen-to-square"></i>-->
                      <!--                          <span class="ml-2">Sửa</span>-->
                      <!--                        </router-link>-->
                      <!--                      </li>-->
                      <li>
                        <button type="button" class="dropdown-item fs-6 text-danger bg-white"
                                @click="">
                          <i class="fa-solid fa-trash"></i>
                          <span class="ml-2">Xóa</span>
                        </button>
                      </li>
                    </ul>
                  </div>
                </td>
              </tr>
              <tr v-if="isLoading && !roomsList.length">
                <td colspan="5" class="text-center">
                  <stateLoading/>
                </td>
              </tr>
              <tr v-if="isNotFound && !isLoading">
                <td colspan="5" class="text-center">Không có phòng</td>
              </tr>
              </tbody>
            </table>
            <div class="pagination">
              <Pagination :pagination="pagination" @pagination-page="getRoomsListByHomestayId"/>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import {ref, onMounted, defineProps, computed, watch} from "vue";
import Pagination from "@/components/Pagination/index.vue";
import MyModal from "@/components/Modal/Modal.vue";
import {useStore} from "vuex";
import stateLoading from "@/components/Loading/Loading.vue";
import {debounce} from "@/utils/debounce";

const isLoading = ref(false);
const store = useStore();
const roomsList = ref([]);
const pagination = ref({});
const sort_direction = ref("desc");
const sort_field = ref("room_id");
const searchInput = ref("");

const props = defineProps({
  homestayId: {
    type: Number,
    required: true,
  }
});

const changeSort = (field) => {
  if (sort_field.value == field) {
    sort_direction.value = sort_direction.value == "asc" ? "desc" : "asc";
  } else {
    sort_field.value = field;
  }
  getRoomsListByHomestayId();
};

const isNotFound = computed(() => (roomsList.value.length === 0 ? true : false));

const getRoomsListByHomestayId = async (page = 1) => {
  isLoading.value = true;
  try {
    const res = await store.dispatch("rooms/fetchRoomsByHomestayId", {
      homestay_id: props.homestayId,
      page,
      sort_field,
      sort_direction,
      searchInput,
    });
    roomsList.value = store.getters["rooms/getRoomsListByHomestayId"];
    pagination.value = res.pagination;
    isLoading.value = false;
  } catch (error) {
    console.error(error);
    isLoading.value = false;
  }
};

onMounted(() => {
  $('#roomsListModal').on("shown.bs.modal", () => {
    getRoomsListByHomestayId();
  });
});

const debouncedGetRoomsList = debounce(getRoomsListByHomestayId, 300);

watch(searchInput, () => {
  debouncedGetRoomsList();
});

</script>

<style scoped>
.rooms-list-modal {
  width: 1700px !important;
}

@media (min-width: 576px) {
  .modal-dialog {
    max-width: 1700px;
    margin: 1.75rem auto;
  }
}
</style>
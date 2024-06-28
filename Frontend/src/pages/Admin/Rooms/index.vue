<template>
  <!--  <ToastMessage :message="successMessage"/>-->

  <div class="col-md-12">
    <div class="card">
      <div class="card-header bg-transparent border-0">
        <div class="d-inline-block fw-bold text-dark fs-4">Danh sách các phòng</div>
      </div>
      <div class="card-body mt-0 w-100">
        <div class="mb-3 d-flex align-items-center justify-content-between">
          <div class="w-25 mt-3 d-flex align-items-center">
            <i class="fa-solid fa-magnifying-glass fs-5 mr-2"></i>
            <!--            <input type="text" name="search" class="form-control small search-input border border-dark-subtletext-dark"-->
            <!--                   placeholder="Tìm kiếm ..." v-model="searchInput"/>-->
          </div>
        </div>
        <table class="table table-bordered table-striped text-dark fw-bold">
          <thead>
          <tr class="text-dark">
            <th>
              ID
            </th>
            <th>
              Tên Phòng
            </th>
            <th class="text-center">Thời gian bắt đâu</th>
            <th class="text-center">Thời gian kết thúc</th>
            <th class="text-center">Trạng thái</th>
            <th class="text-center">Action</th>
          </tr>
          </thead>
          <tbody id="body-table">
          <tr v-for="room in roomsList" :key="room.room_id">
            <td class="text-center">{{ room.room_id }}</td>
            <td class="text-center">
              <a href="" class="text-success text-decoration-none">{{ room.room_number }}</a>
            </td>
            <td class="text-center">{{ room.start_date }}</td>
            <td class="text-center">{{ room.end_date }}</td>
            <td class="text-center">{{ room.status }}</td>
            <td class="text-center">
              <div class="dropdown">
                <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                  Action
                </button>
                <ul class="dropdown-menu">
                  <li>
                    <router-link :to="{ name: 'room.edit', params: { id: room.room_id } }"
                                 class="dropdown-item mb-3 fs-6 text-primary bg-white">
                      <i class="fa-solid fa-pen-to-square"></i>
                      <span class="ml-2">Sửa</span>
                    </router-link>
                  </li>
                  <button type="button" class="dropdown-item fs-6 text-danger bg-white"
                         >
                    <i class="fa-solid fa-trash"></i>
                    <span class="ml-2">Xóa</span>
                  </button>
                </ul>
              </div>
            </td>
          </tr>
<!--          <tr v-if="isLoading && !homestaysList.length">-->
<!--            <td colspan="12" class="text-center">-->
<!--              <stateLoading />-->
<!--            </td>-->
<!--          </tr>-->
<!--          <tr v-if="isNotFound && !isLoading">-->
<!--            <td colspan="12" class="text-center">Không có phòng</td>-->
<!--          </tr>-->
          </tbody>
        </table>
        <div class="pagination">
          <Pagination :pagination="pagination" />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>

import axios from 'axios';
import { useStore } from 'vuex';
import { onBeforeMount, ref } from 'vue';
const store = useStore();
const sort_direction = ref("asc");
const sort_field = ref("room_id");
const searchInput = ref("");
const page = ref(1);
const pagination= ref(1);
const roomsList = ref([]);
import Pagination from "@/components/Pagination/index.vue";

onBeforeMount(() => {
  fetchRoomList();
});
const fetchRoomList = async () => {
     store.dispatch('rooms/fetchRooms',{
       page,
       sort_field,
       sort_direction,
       searchInput,
     }).then((response)=>{
       roomsList.value = store.getters["rooms/getRoomsList"];
       pagination.value = response.pagination;
       // isLoading.value = false;
     });
}

</script>

<style></style>

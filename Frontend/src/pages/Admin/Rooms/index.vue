<template>
  <ToastMessage :message="successMessage"/>

  <div class="col-md-12">
    <div class="card">
      <div class="card-header bg-transparent border-0">
        <div class="d-inline-block fw-bold text-dark fs-4">Danh sách các phòng</div>
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
            <td class="text-center">{{ homestay.status }}</td>
            <td class="text-center">
              <div class="dropdown">
                <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                  Action
                </button>
                <ul class="dropdown-menu">
                  <li>
                    <router-link :to="{ name: 'homestays.edit', params: { id: homestay.homestay_id } }"
                                 class="dropdown-item mb-3 fs-6 text-primary bg-white">
                      <i class="fa-solid fa-pen-to-square"></i>
                      <span class="ml-2">Sửa</span>
                    </router-link>
                  </li>
                  <button type="button" class="dropdown-item fs-6 text-danger bg-white"
                          @click="deleteHomestay(homestay.homestay_id)">
                    <i class="fa-solid fa-trash"></i>
                    <span class="ml-2">Xóa</span>
                  </button>
                </ul>
              </div>
            </td>
          </tr>
          <tr v-if="isLoading && !homestaysList.length">
            <td colspan="12" class="text-center">
              <stateLoading/>
            </td>
          </tr>
          <tr v-if="isNotFound && !isLoading">
            <td colspan="12" class="text-center">Không có homestay</td>
          </tr>
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

</script>

<style></style>

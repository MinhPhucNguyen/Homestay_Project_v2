<template>
   <ToastMessage :message="successMessage" />

   <div class="col-md-12">
      <div class="m-0 d-flex align-items-center justify-content-between">
         <div class="w-50">
            <div class="mb-3 align-items-center d-inline-block mr-4 w-25">
               <div class="d-flex align-items-center">
                  <label for="filterByBrand" class="form-label mb-0 fw-bolder">Filter by Brand:</label>
               </div>
               <select name="filterByBrand" class="form-select mt-2 filter-by" v-model="filterByBrand">
                  <option value="all">All</option>
                  <option v-for="brand in brandsList" :key="brand.brand_id" :value="brand.brand_id">
                     {{ brand.brand_name }}
                  </option>
               </select>
            </div>

            <div class="mb-3 align-items-center d-inline-block ml-2 w-25">
               <div class="d-flex align-items-center">
                  <label for="filterByFuel" class="form-label mb-0 fw-bolder">Filter by Fuel:</label>
               </div>
               <select v-model="filterByFuel" name="filterByFuel" class="form-select mt-2 filter-by-fuel">
                  <option value="all">All fuels</option>
                  <option value="Petrol">Petrol</option>
                  <option value="Diesel">Diesel</option>
               </select>
            </div>
         </div>

         <div class="w-25 mt-3 d-flex align-items-center">
            <i class="fa-solid fa-magnifying-glass fs-5 mr-2"></i>
            <input type="text" name="search" class="form-control small search-input border border-dark-subtletext-dark"
               placeholder="Search for..." v-model="searchInput" />
         </div>
      </div>

      <div class="card">
         <div class="card-header bg-transparent border-0">
            <div class="d-inline-block fw-bold text-dark fs-4">Cars List</div>
            <router-link :to="{ name: 'cars.create' }" class="btn btn-success fw-bold float-right">
               <i class="fa-solid fa-plus"></i>
               Add New Car
            </router-link>
         </div>
         <div class="card-body mt-0">
            <table class="table table-bordered table-striped text-dark fw-bold">
               <thead>
                  <tr class="text-dark">
                     <th data-sort="car_id" @click.prevent="changeSort('car_id')">
                        ID
                        <span class="sort-id-icon float-end">
                           <i class="fa-solid fa-arrow-down" :class="{
                              'text-success': sort_direction == 'desc' && sort_field == 'car_id',
                           }"></i>
                           <i class="fa-solid fa-arrow-up" :class="{
                              'text-success': sort_direction == 'asc' && sort_field == 'car_id',
                           }"></i>
                        </span>
                     </th>
                     <th class="text-center">Brand</th>
                     <th class="text-center" @click.prevent="changeSort('car_name')">
                        Name
                        <span class="sort-id-icon float-end">
                           <i class="fa-solid fa-arrow-down" :class="{
                              'text-success':
                                 sort_direction == 'desc' && sort_field == 'car_name',
                           }"></i>
                           <i class="fa-solid fa-arrow-up" :class="{
                              'text-success':
                                 sort_direction == 'asc' && sort_field == 'car_name',
                           }"></i>
                        </span>
                     </th>
                     <th class="text-center" @click.prevent="changeSort('price')">
                        Price (per day)
                        <span class="sort-id-icon float-end">
                           <i class="fa-solid fa-arrow-down" :class="{
                              'text-success': sort_direction == 'desc' && sort_field == 'price',
                           }"></i>
                           <i class="fa-solid fa-arrow-up" :class="{
                              'text-success': sort_direction == 'asc' && sort_field == 'price',
                           }"></i>
                        </span>
                     </th>
                     <th class="text-center" @click.prevent="changeSort('seats')">
                        Seats
                        <span class="sort-id-icon float-end">
                           <i class="fa-solid fa-arrow-down" :class="{
                              'text-success': sort_direction == 'desc' && sort_field == 'seats',
                           }"></i>
                           <i class="fa-solid fa-arrow-up" :class="{
                              'text-success': sort_direction == 'asc' && sort_field == 'seats',
                           }"></i>
                        </span>
                     </th>
                     <th class="text-center">Fuel</th>
                     <th class="text-center">Fuel Consumption</th>
                     <th class="text-center">Transmission</th>
                     <th class="text-center">Location</th>
                     <th class="text-center" @click.prevent="changeSort('number_of_trip')">
                        Trip
                        <span class="sort-id-icon float-end">
                           <i class="fa-solid fa-arrow-down" :class="{
                              'text-success':
                                 sort_direction == 'desc' && sort_field == 'number_of_trip',
                           }"></i>
                           <i class="fa-solid fa-arrow-up" :class="{
                              'text-success':
                                 sort_direction == 'asc' && sort_field == 'number_of_trip',
                           }"></i>
                        </span>
                     </th>
                     <th class="text-center">Status</th>
                     <th class="text-center">Action</th>
                  </tr>
               </thead>
               <tbody id="body-table">
                  <tr v-for="car in carsList" :key="car.carId">
                     <td class="text-center">{{ car.carId }}</td>
                     <td class="text-center">{{ car.brand }}</td>

                     <td class="text-center">
                        <a href="" class="text-success text-decoration-none">{{ car.carName }}</a>
                     </td>
                     <td class="text-center">{{ car.price }}</td>
                     <td class="text-center">{{ car.seats }}</td>
                     <td class="text-center">{{ car.fuel }}</td>
                     <td class="text-center">{{ car.fuelConsumption }}</td>
                     <td class="text-center">
                        {{ car.transmission == 0 ? "Automatic" : "Manual" }}
                     </td>
                     <td class="text-center">{{ car.location }}</td>
                     <td class="text-center">{{ car.numberOfTrip }}</td>
                     <td class="text-center" :class="car.status == 1 ? 'text-success' : 'text-danger'">
                        {{ car.status == "1" ? "Visibility" : "Unvisibility" }}
                     </td>
                     <td class="text-center">
                        <div class="dropdown">
                           <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown"
                              aria-expanded="false">
                              Action
                           </button>
                           <ul class="dropdown-menu">
                              <li>
                                 <router-link :to="{ name: 'cars.edit', params: { id: car.carId } }"
                                    class="dropdown-item mb-3 fs-6 text-primary bg-white">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    <span class="ml-2">Edit</span>
                                 </router-link>
                              </li>
                              <button type="button" class="dropdown-item fs-6 text-danger bg-white"
                                 @click="deleteCar(car.carId)">
                                 <i class="fa-solid fa-trash"></i>
                                 <span class="ml-2">Delete</span>
                              </button>
                           </ul>
                        </div>
                     </td>

                     <my-modal @clickTo="handleDeleteCar(car.carId)" :idModal="`deleteConfirmModal${car.carId}`"
                        bgColor="danger">
                        <template v-slot:title>Delete car</template>
                        <h6 class="text-dark text-center fs-5 mt-4">
                           Are you sure, you want to delete this car?
                        </h6>
                        <template v-slot:buttonName>
                           <div class="spinner-border" role="status" style="width: 24px; height: 24px; margin-right: 10px"
                              v-if="isLoading">
                              <span class="visually-hidden">Loading...</span>
                           </div>
                           Delete
                        </template>
                     </my-modal>
                  </tr>
                  <tr v-if="isLoading && !carsList.length">
                     <td colspan="12" class="text-center">
                        <stateLoading />
                     </td>
                  </tr>
                  <tr v-if="isNotFound && !isLoading">
                     <td colspan="12" class="text-center">NOT FOUND</td>
                  </tr>
               </tbody>
            </table>
            <div class="pagination">
               <Pagination :pagination="pagination" @pagination-page="getCarsList" />
            </div>
         </div>
      </div>
   </div>
</template>

<script setup>
import { computed, onBeforeMount, ref, watch } from "vue";
import { useStore } from "vuex";
import stateLoading from "@/components/Loading/Loading.vue";
import MyModal from "@/components/Modal/Modal.vue";
import ToastMessage from "@/components/Toast/index.vue";
import Pagination from "@/components/Pagination/index.vue";

const store = useStore();
const brandsList = ref([]);
const carsList = ref([]);
const isLoading = ref(false);
const successMessage = ref(null);
const pagination = ref({});
const filterByBrand = ref("all");
const filterByFuel = ref("all");
const sort_direction = ref("desc");
const sort_field = ref("car_id");
const searchInput = ref("");

const getCarsList = (page = 1) => {
   isLoading.value = true;
   store
      .dispatch("cars/fetchCars", {
         page,
         sort_field,
         sort_direction,
         filterByBrand,
         filterByFuel,
         searchInput,
      })
      .then((res) => {
         carsList.value = store.getters["cars/getCarsList"];
         pagination.value = res.pagination;
         isLoading.value = false;
      });
};

const isNotFound = computed(() => (carsList.value.length === 0 ? true : false));

onBeforeMount(() => {
   getCarsList();
   store.dispatch("cars/fetchBrands").then(() => {
      brandsList.value = store.getters["cars/getBrandsList"];
   });
});

const deleteCar = (id) => {
   $(`#deleteConfirmModal${id}`).modal("show");
};

const handleDeleteCar = (id) => {
   isLoading.value = true;
   store
      .dispatch("cars/deleteCar", id)
      .then((response) => {
         isLoading.value = false;
         $(`#deleteConfirmModal${id}`).modal("hide");
         successMessage.value = response.data.message;
         getCarsList().then(() => {
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

watch(filterByBrand, () => {
   getCarsList();
});

watch(filterByFuel, () => {
   getCarsList();
});

watch(searchInput, () => {
   getCarsList();
});

const changeSort = (field) => {
   if (sort_field.value == field) {
      sort_direction.value = sort_direction.value == "asc" ? "desc" : "asc";
   } else {
      sort_field.value = field;
   }
   getCarsList();
};
</script>

<style></style>

import axios from "axios";

const cars = {
   namespaced: true,
   state: {
      carsList: [],
      brandsList: [],
      featuresList: [],
   },
   getters: {
      getBrandsList(state) {
         return state.brandsList.filter((brand) => brand.status === 0);
      },
      getFeaturesList(state) {
         return state.featuresList;
      },
      getCarsList(state) {
         return state.carsList;
      },
      getCountCars(state) {
         return state.carsList.length;
      },
   },
   mutations: {
      SET_BRANDS_LIST(state, brands) {
         state.brandsList = brands;
      },

      SET_CARS_LIST(state, cars) {
         state.carsList = cars;
      },

      SET_FEATURES_LIST(state, features) {
         state.featuresList = features;
      },
   },
   actions: {
      async fetchBrands({ commit }) {
         return await axios
            .get("v2/admin/brands")
            .then((response) => {
               commit("SET_BRANDS_LIST", response.data.brands);
            })
            .catch((e) => {
               if (e.response) {
                  alert("Something went wrong. Please try again later.");
               }
            });
      },

      async fetchFeatures({ commit }) {
         return await axios
            .get("v2/admin/features")
            .then((response) => {
               commit("SET_FEATURES_LIST", response.data.features);
            })
            .catch((e) => {
               if (e.response) {
                  alert("Something went wrong. Please try again later.");
               }
            });
      },

      async fetchCars({ commit }, payload) {
         try {
            const response = await axios.get(
               "v2/admin/cars?page=" +
                  payload.page +
                  "&search=" +
                  payload.searchInput.value +
                  "&filter_by_brand=" +
                  payload.filterByBrand.value +
                  "&filter_by_fuel=" +
                  payload.filterByFuel.value +
                  "&sort_direction=" +
                  payload.sort_direction.value +
                  "&sort_field=" +
                  payload.sort_field.value
            );
            const data = response.data.data;
            commit("SET_CARS_LIST", data.cars);

            const pagination = {
               currentPage: response.data.meta.current_page,
               lastPage: response.data.meta.last_page,
            };
            return { pagination };
         } catch (error) {
            if (error.response) {
               alert("Something went wrong. Please try again later.");
            }
         }
      },

      async createNewCar({ dispatch }, formData) {
         const response = await axios.post("v2/admin/cars/create", formData, {
            "Content-Type": "multipart/form-data",
         });
         dispatch("fetchCars");
         return response;
      },

      async deleteCar({ dispatch }, id) {
         const response = await axios.delete(`v2/admin/cars/${id}/delete`);
         dispatch("fetchCars");
         return response;
      },
   },
};

export default cars;

import axios from "axios";

const homestays = {
   namespaced: true,
   state: {
      homestaysList: [],
      featuresList: [],
   },
   getters: {
      getFeaturesList(state) {
         return state.featuresList;
      },
      getHomestaysList(state) {
         return state.homestaysList;
      },
      getCountHomestays(state) {
         return state.homestaysList.length;
      },
   },
   mutations: {
      SET_HOMESTAYS_LIST(state, homestays) {
         state.homestaysList = homestays;
      },

      SET_FEATURES_LIST(state, features) {
         state.featuresList = features;
      },
   },
   actions: {
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

      async fetchHomestays({ commit }, payload) {
         try {
            const response = await axios.get(
               "v2/homestays?page=" +
                  payload.page +
                  "&search=" +
                  payload.searchInput.value +
                  "&sort_direction=" +
                  payload.sort_direction.value +
                  "&sort_field=" +
                  payload.sort_field.value
            );
            const data = response.data.data;
            commit("SET_HOMESTAYS_LIST", data.homestays);

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

export default homestays;

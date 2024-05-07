import axios from "axios";

const favorite = {
   namespaced: true,
   state: {
      favoriteCars: [],
   },
   getters: {
      getFavoriteCars(state) {
         return state.favoriteCars;
      },
   },
   mutations: {
      SET_FAVORITE_CARS(state, cars) {
         state.favoriteCars = cars;
      },
   },
   actions: {
      async fetchFavoriteCars({ commit }) {
         try {
            const response = await axios.get("v2/fav/favorite-cars");
            const favoriteCars = response.data.data.cars;
            commit("SET_FAVORITE_CARS", favoriteCars);
         } catch (e) {
            commit("SET_FAVORITE_CARS", []);
         }
      },

      async addCar({ dispatch }, payload) {
         try {
            const response = await axios.post("v2/fav/add-car/" + payload.id);
            dispatch("fetchFavoriteCars");
            return response;
         } catch (e) {
            if (e.response) {
               return e.response;
            }
         }
      },

      async removeCar({ dispatch }, payload) {
         try {
            const response = await axios.post("v2/fav/remove-car/" + payload.id);
            dispatch("fetchFavoriteCars");
            return response;
         } catch (e) {
            if (e.response) {
               return e.response;
            }
         }
      },
   },
};

export default favorite;

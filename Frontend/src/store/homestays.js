import axios from "axios";

const homestays = {
    namespaced: true,
    state: {
        homestaysList: [],
    },
    getters: {
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
    },
    actions: {

        async fetchHomestays({commit}, payload) {
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
                return {pagination};
            } catch (e) {
                if (e.response) {
                    alert("Something went wrong. Please try again later.");
                }
            }
        },

        async createNewHomestay({dispatch}, formData) {
            const response = await axios.post("v2/homestays/create", formData, {
                "Content-Type": "multipart/form-data",
            });
            dispatch("fetchHomestays");
            return response;
        },

        async deleteHomestay({dispatch}, id) {
            const response = await axios.delete(`v2/homestays/${id}/delete`);
            dispatch("fetchHomestays");
            return response;
        },
    },
};

export default homestays;

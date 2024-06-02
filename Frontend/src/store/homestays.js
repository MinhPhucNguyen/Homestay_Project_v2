import axios from "axios";

const homestays = {
    namespaced: true,
    state: {
        homestaysList: [],
        roomTypesList: [],
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
        getRoomTypesList(state) {
            return state.roomTypesList;
        }
    },
    mutations: {
        SET_HOMESTAYS_LIST(state, homestays) {
            state.homestaysList = homestays;
        },

        SET_FEATURES_LIST(state, features) {
            state.featuresList = features;
        },

        SET_ROOM_TYPES_LIST(state, roomTypes) {
            state.roomTypesList = roomTypes;
        }
    },
    actions: {
        async fetchFeatures({commit}) {
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

        async fetchRoomTypes({commit}) {
            return await axios
                .get("v2/admin/room-types")
                .then((response) => {
                    commit("SET_ROOM_TYPES_LIST", response.data.room_types);
                })
                .catch((e) => {
                    if (e.response) {
                        alert("Something went wrong. Please try again later.");
                    }
                });
        },

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

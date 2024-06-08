import axios from "axios";

const roomTypes = {
    namespaced: true,
    state: {
        roomTypesList: [],
    },
    getters: {
        getRoomTypesList(state) {
            return state.roomTypesList;
        }
    },
    mutations: {
        SET_ROOM_TYPES_LIST(state, roomTypes) {
            state.roomTypesList = roomTypes;
        }
    },
    actions: {
        async fetchRoomTypes({commit}, payload) {
            return await axios
                .get("v2/room-types?page=" + payload.page)
                .then((response) => {
                    commit("SET_ROOM_TYPES_LIST", response.data.data.roomTypes);

                    const pagination = {
                        currentPage: response.data.meta.current_page,
                        lastPage: response.data.meta.last_page,
                    };
                    return {pagination};
                })
                .catch((e) => {
                    if (e.response) {
                        alert("Something went wrong. Please try again later.");
                    }
                });
        },
    },
};

export default roomTypes;

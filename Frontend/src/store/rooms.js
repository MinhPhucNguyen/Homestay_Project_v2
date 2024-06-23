import axios from "axios";

const rooms = {
    namespaced: true,
    state: {
        roomsList: [],
        roomsListByHomestayId: [],
    },
    getters: {
        getRoomsList(state) {
            return state.roomsList;
        },
        getRoomsListByHomestayId: (state) => (id) => {
            return state.roomsListByHomestayId;
        }
    },
    mutations: {
        SET_ROOMS_LIST(state, rooms) {
            state.roomsList = rooms;
        },
        SET_ROOMS_LIST_BY_HOMESTAY_ID(state, rooms) {
            state.roomsListByHomestayId = rooms;
        },
    },
    actions: {
        async fetchRoomsByHomestayId({commit}, payload) {
            try {
                const response = await axios.get(
                    "v2/rooms/getByHomestay/" + payload.homestay_id +
                    "?page=" +
                    payload.page +
                    "&search=" +
                    payload.searchInput.value +
                    "&sort_direction=" +
                    payload.sort_direction.value +
                    "&sort_field=" +
                    payload.sort_field.value
                );
                const data = response.data.data;
                const dataRoom = data.rooms
                const pagination = {
                    currentPage: response.data.meta.current_page,
                    lastPage: response.data.meta.last_page,
                };
                return {pagination, dataRoom};
            } catch (e) {
                if (e.response) {
                    alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
                }
            }
        },

        async fetchRooms({commit}, payload) {
            try {
                const response = await axios.get(
                    "v2/rooms?page=" +
                    payload.page +
                    "&search=" +
                    payload.searchInput.value +
                    "&sort_direction=" +
                    payload.sort_direction.value +
                    "&sort_field=" +
                    payload.sort_field.value
                );
                const data = response.data.data;
                commit("SET_ROOMS_LIST", data.rooms);

                const paginationfetchRooms = {
                    currentPage: response.data.meta.current_page,
                    lastPage: response.data.meta.last_page,
                };
                return {pagination};
            } catch (e) {
                if (e.response) {
                    alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
                }
            }
        },
    },
};

export default rooms;

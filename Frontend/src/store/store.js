import { createStore } from "vuex";
import auth from "./auth";
import users from "./users";
import homestays from "./homestays";
import roomTypes from "./roomTypes";
import rooms from "./rooms";

const store = createStore({
   modules: {
      auth,
      users,
      homestays,
      rooms,
      roomTypes
   },
});

export default store;

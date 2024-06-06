import { createStore } from "vuex";
import auth from "./auth";
import users from "./users";
import homestays from "./homestays";
import roomTypes from "./roomTypes";

const store = createStore({
   modules: {
      auth,
      users,
      homestays,
      roomTypes
   },
});

export default store;

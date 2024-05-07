import { createStore } from "vuex";
import auth from "./auth";
import users from "./users";
import cars from "./cars";
import favorite from "./favorite";

const store = createStore({
   modules: {
      auth,
      users,
      cars,
      favorite,
   },
});

export default store;

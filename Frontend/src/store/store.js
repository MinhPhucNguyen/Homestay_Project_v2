import { createStore } from "vuex";
import auth from "./auth";
import users from "./users";
import cars from "./cars";

const store = createStore({
   modules: {
      auth,
      users,
      cars,
   },
});

export default store;

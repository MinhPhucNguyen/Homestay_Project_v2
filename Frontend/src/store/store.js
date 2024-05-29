import { createStore } from "vuex";
import auth from "./auth";
import users from "./users";
import homestays from "./homestays";

const store = createStore({
   modules: {
      auth,
      users,
      homestays,
   },
});

export default store;

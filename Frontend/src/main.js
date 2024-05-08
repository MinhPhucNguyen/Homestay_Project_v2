import "./assets/styles/globalstyles.scss";
import "../public/admin/vendor/bootstrap/js/bootstrap.bundle.min.js";
import "../public/admin/vendor/jquery/jquery.min.js";
import CKEditor from "@ckeditor/ckeditor5-vue";
import { createApp } from "vue";
import App from "./App.vue";
import router from "./router/index";
import store from "./store/store";
import axios from "axios";
import { library } from "@fortawesome/fontawesome-svg-core";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { fas } from "@fortawesome/free-solid-svg-icons";
import jquery from "jquery";
window.$ = window.jQuery = jquery;

library.add(fas);

require("@/store/subscriber");
axios.defaults.baseURL = "http://127.0.0.1:8000/api";

/**
 * TODO: Kiểm tra xem người dùng đã đăng nhập hay chưa bằng cách kiểm tra localStorage có token hay không
 */
store.dispatch("auth/attempt", localStorage.getItem("token")).then(() => {
   const app = createApp(App);
   app.use(router);
   app.use(store);
   app.use(CKEditor);
   app.component("font-awesome-icon", FontAwesomeIcon);
   app.mount("#app"); //mount() vào #app
});

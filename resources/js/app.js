import CartManager from "./CartManager";

import axios from "axios";
import jQuery from "jquery";

window.axios = axios;
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
window.axios.defaults.headers.common["X-CSRF-TOKEN"] =
  document.head.querySelector('meta[name="csrf-token"]').content;
window.axios.defaults.headers.common["Content-Type"] = "application/json";
window.axios.defaults.headers.common["Accept"] = "application/json";

window.jQuery = jQuery;
window.$ = jQuery;

window.CartManager = CartManager;

$(document).ready(() => {
  CartManager.load();
});

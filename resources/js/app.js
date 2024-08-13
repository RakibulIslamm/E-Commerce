import "./bootstrap";
import "./cart";

import Alpine from "alpinejs";
import * as commonUtils from "./utils/common";

window.Alpine = Alpine;
window.commonUtils = commonUtils;
let all_cart = {};
window.all_cart = all_cart;

Alpine.start();

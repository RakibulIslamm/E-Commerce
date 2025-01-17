import "./bootstrap";
import "./cart";

import Alpine from "alpinejs";
import * as commonUtils from "./utils/common";

window.Alpine = Alpine;
window.commonUtils = commonUtils;
let all_cart = {};
window.all_cart = all_cart;

Alpine.start();

window.addEventListener("resize", () => {
  const vh = window.innerHeight * 0.01;
  document.documentElement.style.setProperty("--vh", `${vh}px`);
});

const vh = window.innerHeight * 0.01;
document.documentElement.style.setProperty("--vh", `${vh}px`);


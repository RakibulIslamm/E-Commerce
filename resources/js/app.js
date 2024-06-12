import "./bootstrap";

import Alpine from "alpinejs";
import * as commonUtils from "./utils/common";

window.Alpine = Alpine;
window.commonUtils = commonUtils;

const session = document.getElementById("session_status");
document.getElementById("icon").addEventListener("click", () => {
    session.classList.add("hidden");
    session.classList.remove("flex");
});

Alpine.start();

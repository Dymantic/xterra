import jump from "jump.js";

[...document.querySelectorAll("[data-jump-target]")].forEach((link) => {
    link.addEventListener("click", (ev) => {
        ev.preventDefault();
        jump(`#${link.getAttribute("data-jump-target")}`, { offset: -168 });
    });
});

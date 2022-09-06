const body= document.querySelector(".js-body")

const burger = document.querySelector(".burger");
const navbar = document.querySelector(".nav-bar");

burger.addEventListener("click", () => {
    burger.classList.toggle("active");
    navbar.classList.toggle("active");
});
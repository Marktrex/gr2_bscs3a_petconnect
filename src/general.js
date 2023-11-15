// navbar click responsive
const aside = document.querySelector("#sidenav");
const menuBtn = document.querySelector("#menu-btn");
const closeBtn = document.querySelector("#close-btn");

menuBtn.addEventListener("click", () => aside.classList.toggle("mobile-mode"));

closeBtn.addEventListener("click", () => menuBtn.click());


// updating profile
let profilePic = document.getElementById("profile-pic");
let inputFile = document.getElementById("input-file");

inputFile.onchange = function () {
    profilePic.src = URL.createObjectURL(inputFile.files[0]);
};
addEventOnNav();

function addEventOnNav() {
  const header = document.querySelector(".navbar");
  const hamburgerBtn = document.querySelector("#hamburger-btn");
  const closeMenuBtn = document.querySelector("#close-menu-btn");

  // Toggle mobile menu on hamburger button click
  hamburgerBtn.addEventListener("click", function () {
    header.classList.toggle("show-mobile-menu");
    changeHeaderColor("#fff");
  });

  // Close mobile menu on close button click
  closeMenuBtn.addEventListener("click", () => hamburgerBtn.click());
}

window.addEventListener("scroll", function () {
  let scrollPosition = window.scrollY;
  let textColor = null;
  if (scrollPosition > 50) {
    // scroll below
    textColor = "#e89003";
  } else {
    // on top
    textColor = "#fff";
  }
  changeHeaderColor(textColor);
});

function changeHeaderColor(textColor) {
  const header = document.querySelector(".navbar");

  let scrollPosition = window.scrollY;

  // Change the background color of the navbar based on the scroll position
  let backgroundColor = null;
  if (scrollPosition > 50) {
    // scroll below
    backgroundColor = "#fff6e8";
    textColor = "#e89003";
  } else {
    // on top
    backgroundColor = "transparent";
    textColor = "#fff";
  }

  header.style.backgroundColor = backgroundColor; // Change to your desired color

  if (header.classList.contains("show-mobile-menu")) {
    textColor = "#e89003";
  }
  header.querySelectorAll("a,span").forEach(function (a) {
    a.style.color = textColor; // Change to your desired text color
  });
}

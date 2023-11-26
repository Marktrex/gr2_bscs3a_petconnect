addEventOnNav();
activeLink();

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
  header.querySelectorAll("li > a, li > .dropdown > label, li > .dropdown > label > span").forEach(function (a) {
    a.style.cssText = `color: ${textColor}`; // Change to your desired text color
  });
  activeLink();
}

function activeLink() {
  // Get the current URL
  let currentUrl = window.location.href;

  // Select all the navbar links
  let navbarLinks = document.querySelectorAll("nav a");

  // Iterate over each link
  navbarLinks.forEach((link) => {
    // Compare the href attribute with the current URL
    if (link.href === currentUrl) {
      // If they match, add an attribute 'active' with the value 'true'
      link.setAttribute("active", "true");
      link.style.color = "#127475";
    }
  });
}

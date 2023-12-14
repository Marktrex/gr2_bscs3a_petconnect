
const navColors = {
  light: {
      "navbar-responsive-bg-color": "#fdf7ec",
      "navbar-text-color": "#fff",
      "navbar-hover-color": "#127475",
      "navbar-active-color": "rgb(242, 84, 45)"
  },
  dark: {
      "navbar-responsive-bg-color": "#442467",
      "navbar-text-color": "#1eddd4",
      "navbar-hover-color": "#4a9b97",
      "navbar-active-color": "#ab62ff"
  }
};

addEventOnNav();
activeLink();


function addEventOnNav() {
  const header = document.querySelector(".navbar");
  const hamburgerBtn = document.querySelector("#hamburger-btn");
  const closeMenuBtn = document.querySelector("#close-menu-btn");

  // Toggle mobile menu on hamburger button click
  hamburgerBtn.addEventListener("click", function () {
    console.log(header);
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
    if(checkRootForDark()){
      textColor = navColors.dark["navbar-text-color"];
    } else{
      textColor = navColors.light["navbar-text-color"];
    }
  } else {
    // on top
    textColor = "#fff";
  }
  changeHeaderColor(textColor);
});

function changeHeaderColor(textColor) {
  const header = document.querySelector(".navbarContainer");
  // Check if the viewport width exceeds 800px
  if (window.innerWidth < 1024) {
    if(checkRootForDark()){
      textColor = navColors.dark["navbar-text-color"];
    } else{
      textColor = navColors.light["navbar-text-color"];
    }
    header.querySelectorAll("li > div > a , li > a, li > .dropdown > label, li > .dropdown > label > span").forEach(function (a) {
      a.style.cssText = `color: ${textColor}`; // Change to your desired text color
    });
    return; // Exit the function
  }
  
  let scrollPosition = window.scrollY;

  // Change the background color of the navbar based on the scroll position
  let backgroundColor = null;
  if (scrollPosition > 50) {
    // scroll below
    if(checkRootForDark()){
      backgroundColor = navColors.dark["navbar-responsive-bg-color"];
    } else{
      backgroundColor = navColors.light["navbar-responsive-bg-color"];
    }
  } else {
    // on top
    backgroundColor = "transparent";
  }

  header.style.backgroundColor = backgroundColor; // Change to your desired color

  if (header.classList.contains("show-mobile-menu")) {
    if(checkRootForDark()){
      textColor = navColors.dark["navbar-text-color"];
    } else{
      textColor = navColors.light["navbar-text-color"];
    }
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
      if(checkRootForDark()){
        link.style.color = navColors.dark["navbar-active-color"];
      } else{
        link.style.color = navColors.light["navbar-active-color"];
      }
    }
  });
}


function checkRootForDark(){
  const root = document.documentElement; // Get the root element
  const theme = root.getAttribute('data-theme'); // Get the value of the 'data-theme' attribute
  return theme === 'dark'; // Return true if the theme is 'dark', false otherwise
}
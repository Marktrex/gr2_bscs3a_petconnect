
activeLink();
// navbar click responsive
const aside = document.querySelector("#sidenav");
const menuBtn = document.querySelector("#menu-btn");
const closeBtn = document.querySelector("#close-btn");

menuBtn.addEventListener("click", () => aside.classList.toggle("mobile-mode"));

closeBtn.addEventListener("click", () => menuBtn.click());


// updating profile
let profilePic = document.getElementById("profile-pic");
let inputFile = document.getElementById("image");
if(profilePic && inputFile) {
    inputFile.onchange = function () {
      profilePic.src = URL.createObjectURL(inputFile.files[0]);
  };
}



function activeLink() {
    // Get the current URL
    let currentUrl = window.location.href;
  
    // Select all the navbar links
    let navbarLinks = document.querySelectorAll("aside a");
  
    // Iterate over each link
    navbarLinks.forEach((link) => {
      // Compare the href attribute with the current URL
      if (link.href === currentUrl) {
        // If they match, add an attribute 'active' with the value 'true'
        link.classList.add("active");
      }
    });
  }
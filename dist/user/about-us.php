<?php
require '../function/config.php';
session_start(); // Add this line to start the session
if (!isset($_SESSION['auth_user'])) {
  // Redirect to login page if the user is not authenticated
  header("Location: ../authentication/loginpage.php");
  exit();
}

if ($_SESSION['auth_user']['role'] === "1") { 
  // Redirect to admin dashboard if the user has admin role
  header("Location: ../admin/admin-dashboard.php");
  exit();
}?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PetConnet Homepage</title>
  <link rel="stylesheet" href="../css/newlyAdded/about-us.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0">
  <link rel="stylesheet" href="..\css\colorStyle\user\about-us-color.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="..\css\colorStyle\user\about-us-color.css">
</head>

<body>
  <?php require_once "../components/user/fixedNavbar.php"?>
    <main>
      <div class="about-section">
        <div>
          <h1>About Us</h1>
            <p class="text">
            PetConnect raises awareness about the value of animal rescue and the difficulties they encounter. We advocate responsible pet ownership and emphasize issues related to animal overpopulation and abandonment.            </p>
        </div>
        <div>
        </div>
      </div>
      <div class="team">
        <h1>Our team</h1>
        <div class="wrapper">
            <i id="left" class="fa-solid fa-angle-left"></i>
            <ul class="carousel">
              <li class="card">
                <div class="img"><img src="../image/team/nyah.jpg" alt="img" draggable="false"></div>
                <h2>Castilio, Nyah</h2>
                <span>Leader</span>
              </li>
              <li class="card">
                <div class="img"><img src="../image/team/Marc_David.jpeg" alt="img" draggable="false"></div>
                <h2>David, Marc</h2>
                <span>Backend Lead Developer</span>
              </li>
              <li class="card">
                <div class="img"><img src="../image/team/Armyn_Jace.jpg" alt="img" draggable="false"></div>
                <h2>Ibay, Armyn Jace</h2>
                <span>SoftEng Lead Producer</span>
              </li>
              <li class="card">
                <div class="img"><img src="../image/team/Airam_Aguilar.JPG" alt="img" draggable="false"></div>
                <h2>Aguilar, Airam</h2>
                <span>Lead for Video</span>
              </li>
              <li class="card">
                <div class="img"><img src="../image/team/Buglosa, Kriesha Mae T.jpg" alt="img" draggable="false"></div>
                <h2>Buglosa, Kriesha</h2>
                <span>Nyah's Assistant</span>
              </li>
              <li class="card">
                <div class="img"><img src="../image/team/Feliciano, EJ.jpg" alt="img" draggable="false"></div>
                <h2>Feliciano, EJ</h2>
                <span>Singer</span>
              </li>
              <li class="card">
                <div class="img"><img src="../image/team/Mark_Kevin.jpg" alt="img" draggable="false"></div>
                <h2>De Dios, Mark</h2>
                <span>Hidden talent</span>
              </li>
              <li class="card">
                <div class="img"><img src="../image/team/Mark_lerit.jpeg" alt="img" draggable="false"></div>
                <h2>Lerit, Mark</h2>
                <span>Beginner Expert</span>
              </li>
              <li class="card">
                <div class="img"><img src="../image/team/ryand.jpg" alt="img" draggable="false"></div>
                <h2>Soriano, Ryand, M.</h2>
                <span>Beginner Expert</span>
              </li>
              <li class="card">
                <div class="img"><img src="../image/team/Aries_Tagle.png" alt="img" draggable="false"></div>
                <h2>Tagle, Aries</h2>
                <span>Dumbbell</span>
              </li>
            </ul>
            <i id="right" class="fa-solid fa-angle-right"></i>
          </div>
        </div>
        <div class="extraInfo">
        <div>
          <h1>Contact Us</h1>
          <br><br><br><br>
            <h4>Gmail: PetConnect@gmail.com</h4><br>
            <h4>Phone Number: 09123456789</h4><br>
            <h4>Viber: 09123456789</h4><br>
            <!-- Add more contacts as needed -->
          
        </div>
        <div>
          <h1>Address</h1>
          <br><br><br>
            <img src="..\image\gcash-bank\address.png" alt="">
            <!-- Add more contacts as needed -->
        </div>
        </div>
    </main>
    <?php require_once "..\components\light-switch.php"?>
    <?php require_once "../components/user/footer.html"?>
    <?php require_once "..\components\call_across_pages.php"?>
</body>
<script>
  const wrapper = document.querySelector(".wrapper");
  const carousel = document.querySelector(".carousel");
  const firstCardWidth = carousel.querySelector(".card").offsetWidth;
  const arrowBtns = document.querySelectorAll(".wrapper i");
  const carouselChildrens = [...carousel.children];

  let isDragging = false, isAutoPlay = true, startX, startScrollLeft, timeoutId;

  // Get the number of cards that can fit in the carousel at once
  let cardPerView = Math.round(carousel.offsetWidth / firstCardWidth);

  // Insert copies of the last few cards to beginning of carousel for infinite scrolling
  carouselChildrens.slice(-cardPerView).reverse().forEach(card => {
      carousel.insertAdjacentHTML("afterbegin", card.outerHTML);
  });

  // Insert copies of the first few cards to end of carousel for infinite scrolling
  carouselChildrens.slice(0, cardPerView).forEach(card => {
      carousel.insertAdjacentHTML("beforeend", card.outerHTML);
  });

  // Scroll the carousel at appropriate postition to hide first few duplicate cards on Firefox
  carousel.classList.add("no-transition");
  carousel.scrollLeft = carousel.offsetWidth;
  carousel.classList.remove("no-transition");

  // Add event listeners for the arrow buttons to scroll the carousel left and right
  arrowBtns.forEach(btn => {
      btn.addEventListener("click", () => {
          carousel.scrollLeft += btn.id == "left" ? -firstCardWidth : firstCardWidth;
      });
  });

  const dragStart = (e) => {
      isDragging = true;
      carousel.classList.add("dragging");
      // Records the initial cursor and scroll position of the carousel
      startX = e.pageX;
      startScrollLeft = carousel.scrollLeft;
  }

  const dragging = (e) => {
      if(!isDragging) return; // if isDragging is false return from here
      // Updates the scroll position of the carousel based on the cursor movement
      carousel.scrollLeft = startScrollLeft - (e.pageX - startX);
  }

  const dragStop = () => {
      isDragging = false;
      carousel.classList.remove("dragging");
  }

  const infiniteScroll = () => {
      // If the carousel is at the beginning, scroll to the end
      if(carousel.scrollLeft === 0) {
          carousel.classList.add("no-transition");
          carousel.scrollLeft = carousel.scrollWidth - (2 * carousel.offsetWidth);
          carousel.classList.remove("no-transition");
      }
      // If the carousel is at the end, scroll to the beginning
      else if(Math.ceil(carousel.scrollLeft) === carousel.scrollWidth - carousel.offsetWidth) {
          carousel.classList.add("no-transition");
          carousel.scrollLeft = carousel.offsetWidth;
          carousel.classList.remove("no-transition");
      }

      // Clear existing timeout & start autoplay if mouse is not hovering over carousel
      clearTimeout(timeoutId);
      if(!wrapper.matches(":hover")) autoPlay();
  }

  const autoPlay = () => {
      if(window.innerWidth < 800 || !isAutoPlay) return; // Return if window is smaller than 800 or isAutoPlay is false
      // Autoplay the carousel after every 2500 ms
      timeoutId = setTimeout(() => carousel.scrollLeft += firstCardWidth, 2500);
  }
  autoPlay();

  carousel.addEventListener("mousedown", dragStart);
  carousel.addEventListener("mousemove", dragging);
  document.addEventListener("mouseup", dragStop);
  carousel.addEventListener("scroll", infiniteScroll);
  wrapper.addEventListener("mouseenter", () => clearTimeout(timeoutId));
  wrapper.addEventListener("mouseleave", autoPlay);
</script>
</html>
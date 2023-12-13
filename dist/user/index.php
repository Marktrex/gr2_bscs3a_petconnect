<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PetConnect | Index</title>
    <link rel="stylesheet" href="../css/newlyAdded/landing-page-light.css" />
    <link rel="stylesheet" href="../css/newlyAdded/slider.css" />  
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />

    <link rel="stylesheet" href="..\css\colorStyle\user\landing-page-color.css">
    <link rel="stylesheet" href="..\css\colorStyle\user\footer-color.css">
  </head>

  <body>
    <?php require_once "../components/user/userNavbar.php"?>

    <section class="hero-section">
      <div>
        <div class="content">
          <h1>
            Give our Furry Companions <br />a chance to have their Forever Homes
          </h1>
          <p>
            Adopting rescued animals not only saves lives but also fills your heart with boundless love and gratitude.
          </p>
          <button class="register-button" onclick="window.location.href='../authentication/signuppage.php'">
            <span>Get Started</span>
          </button>
        </div>
        <div class="photodecor">
          <img src="../icons/photodecor1.png" alt="" />
        </div>
      </div>
    </section>

    <main class="container1">
      <div>
        <h1>Our Services</h1>
        <div class="services">
          <div class="item service1">
            <img src="../icons/vidconference.png" alt="" />
            <h1>Video Conference</h1>
            <p>
              We utilized video conferencing platforms to conduct virtual meet-and-greet sessions between the adopter and the pet.
            </p>
          </div>
          <div class="item service2">
            <img src="../icons/booking.png" alt="" />
            <h1>Online Booking</h1>
            <p>
              This enables to choose a date in your comfort of your own schedule.
            </p>
          </div>
          <div class="item service3">
            <img src="../icons/docu.png" alt="" />
            <h1>Legal Documentation</h1>
            <p>
              It may include details such as the responsibilities of the adopter, any adoption fees, and clauses related to the well-being of the pet.
            </p>
          </div>
        </div>
      </div>
    </main>

    <div class="container2">  
      <div class="item images"></div>
      <!--src: slider.css-->
      <div class="item purpose">
        <h1>Our Purpose</h1>

        <p>
          PetConnect raises awareness about the value of animal rescue and the difficulties they encounter. We advocate responsible pet ownership and emphasize issues related to animal overpopulation and abandonment.<br /><br />
        </p>

        <p>
        People can access our website from anywhere with an internet connection, as compared to actual adoption centers, which have a limited geographical reach. PetConnect broadens the pool of potential adopters and increases the possibilities of the animals finding loving homes.<br /><br />
        </p>

        <p>
        We also accept donations, which can help cover the costs associated with rescuing, rehabilitating, and caring for animals. We also provide information on how supporters can contribute in other ways, such as volunteering or providing supplies.<br />
        </p>
      </div>
    </div>

    <?php require_once '..\components\light-switch.php'?>
    <?php require_once "../components/user/footer.html"?>
    
  </body>
</html>
